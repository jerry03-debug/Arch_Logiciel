
// Fonction pour créer une carte à partir d'un objet article
function createCard(article) {
    const card = document.createElement('div');
    card.className = 'card';

    const title = document.createElement('h2');
    title.textContent = article.titre;
    card.appendChild(title);

    const content = document.createElement('p');
    content.textContent = article.contenu;
    card.appendChild(content);

    const date = document.createElement('p');
    date.textContent = `Créé le : ${article.dateCreation}`;
    card.appendChild(date);

    return card;
}

// Fonction pour récupérer les articles depuis le endpoint
function fetchArticles() {
    fetch('http://localhost/Arch_Logiciel/backend/get_articles.php')
        .then(response => response.json()) // Convertir la réponse en JSON
        .then(articles => {
            const articlesContainer = document.getElementById('articles-container');
            articles.forEach(article => {
                const card = createCard(article);
                articlesContainer.appendChild(card);
            });
        })
        .catch(error => console.error('Erreur lors du chargement des articles:', error));
}

// Fonction pour récupérer les categories depuis le endpoint
function fetchCategories() {
    fetch('http://localhost/Arch_Logiciel/backend/get_categories.php')
        .then(response => response.json()) // Convertir la réponse en JSON
        .then(categories => {
            const container = document.getElementById('categories-container');

            categories.forEach(categorie => {
                console.log(categorie)
                const categorieLi = document.createElement("li")
                categorieLi.className = "categories_liste"
                categorieLi.textContent = categorie?.libelle;

                //Fonction pour recuperer les articles par categorie
                categorieLi.addEventListener("click", () => {
                    // URL pour récupérer les articles par catégorie
                    const url = `http://localhost/Arch_Logiciel/backend/get_by_categories.php?categorie=${categorie.id}`;
                    const articlesContainer = document.getElementById('articles-container');
                    articlesContainer.innerHTML = "";  // Effacer le contenu précédent
                    // Récupérer les articles par catégorie
                    fetch(url)
                        .then((response) => {
                            const articlesByCategory =[]
                            if (!response.ok) {

                                const errorMessage = document.createElement("p");
                                errorMessage.textContent="Aucun article pour cette categorie !"
                                errorMessage.className = "errorMessage"
                                articlesContainer.appendChild(errorMessage)
                                
                                throw new Error("Erreur lors de la récupération des articles");

                            }
                            return response.json();
                        })
                        .then((articles) => {
                            const articlesByCategory = []
                            const articlesContainer = document.getElementById('articles-container');

                            articlesByCategory.push(articles)

                            // Ajouter les articles au conteneur
                            articlesByCategory?.map((article) => {
                                console.log("article",article)
                               const card = createCard(article);
                               articlesContainer.appendChild(card);
                            });
                        })
                        .catch((error) => {
                            console.error(error.message);
                            // Vous pouvez ajouter un message d'erreur dans le conteneur si nécessaire
                        });
                });

                container.appendChild(categorieLi);
            });
        })
        .catch(error => console.error('Erreur lors du chargement des articles:', error));
}

// Charger les articles et les categories lors du chargement de la page
window.onload = function () {
    fetchArticles()
    fetchCategories()
};
