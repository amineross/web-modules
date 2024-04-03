const adresseInput = document.getElementById('adresseInput');
const suggestionsList = document.getElementById('suggestionsList');

let selectedAddress = false;
let validAddresses = [];

adresseInput.addEventListener('input', function() {
    const inputValue = adresseInput.value;

    // Utilisez l'API BAN pour récupérer les suggestions en fonction de inputValue
    // Exemple d'URL de l'API BAN : https://api-adresse.data.gouv.fr/search/?q=${inputValue}
    // Vous pouvez utiliser fetch() ou une bibliothèque comme axios pour faire la requête.

    // Ensuite, traitez la réponse de l'API et affichez les suggestions.
    fetch(`https://api-adresse.data.gouv.fr/search/?q=${inputValue}`)
        .then(response => response.json())
        .then(data => {
            const suggestions = data.features;
            afficherSuggestions(suggestions);
            if (suggestions.length > 0){
                suggestionsList.style.display = "block";
            } else {
                suggestionsList.style.display = "none";
            }
        })
        .catch(error => console.error('Erreur lors de la récupération des suggestions:', error));
});

function afficherSuggestions(suggestions) {
    suggestionsList.innerHTML = ''; 
    validAddresses = []; 

    suggestions.forEach(suggestion => {
        const li = document.createElement('li');
        li.textContent = suggestion.properties.label;
        validAddresses.push(suggestion.properties.label); 

        li.addEventListener("click", () => {
            adresseInput.value = li.textContent;
            selectedAddress = true;
            suggestionsList.style.display = "none";
        });
        suggestionsList.appendChild(li);
    });
}

document.addEventListener("click", (e) => {
    if (!adresseInput.contains(e.target)) {s
        suggestionsList.style.display = "none";
    }
});

const form = document.querySelector("form");

form.addEventListener("submit", (e) => {
    const inputValue = adresseInput.value;
    const isValidAddress = validAddresses.includes(inputValue);

    if (!isValidAddress) {
        e.preventDefault();
        alert('Veuillez sélectionner une adresse valide.');
        adresseInput.focus();
    }
});


