// Init map
var mymap = L.map('mapid').setView([48.0725, -0.7702], 13);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(mymap);

var marker = L.marker([48.0725, -0.7702], {draggable: true}).addTo(mymap);
marker.on('dragend', function(e) {
    var newPos = marker.getLatLng();
    fetchWeatherData(newPos.lat, newPos.lng);
});

document.addEventListener('DOMContentLoaded', function() {
    console.log("Loaded.");
    fetchWeatherData();
});

// Laval default
function fetchWeatherData(latitude = 48.0725, longitude = -0.7702) {

    const apiUrl = `https://api.open-meteo.com/v1/forecast?latitude=${latitude}&longitude=${longitude}&current=temperature_2m,weather_code&forecast_days=1`;

    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            console.log(data);
            displayWeatherInfo(data);
        })
        .catch(error => {
            console.error('Error fetching weather data:', error);
            document.getElementById('weatherInfo').textContent = 'Impossible de charger les informations météorologiques.';
        });
}


function mapWmoCodeToIcon(weatherCode) {
    const weatherCodeMap = {
        '0': '01d', // Clear sky
        '1': '02d', // Partly cloudy
        '2': '03d', // Cloudy
        '3': '04d', // Overcast
        '45': '09d', // Fog
        '48': '50d', // Depositing rime fog
        '51': '09d', // Drizzle: Light
        '53': '09d', // Drizzle: Moderate
        '55': '09d', // Drizzle: Dense intensity
        '56': '13d', // Freezing Drizzle: Light
        '57': '13d', // Freezing Drizzle: Dense intensity
        '61': '10d', // Rain: Slight intensity
        '63': '10d', // Rain: Moderate intensity
        '65': '10d', // Rain: Heavy intensity
        '66': '13d', // Freezing Rain: Light
        '67': '13d', // Freezing Rain: Heavy intensity
        '71': '13d', // Snow fall: Slight intensity
        '73': '13d', // Snow fall: Moderate intensity
        '75': '13d', // Snow fall: Heavy intensity
        '77': '13d', // Snow grains
        '80': '09d', // Rain showers: Slight
        '81': '09d', // Rain showers: Moderate
        '82': '09d', // Rain showers: Violent
        '85': '13d', // Snow showers slight
        '86': '13d', // Snow showers heavy
        '95': '11d', // Thunderstorm: Slight or moderate
        '96': '11d', // Thunderstorm with slight hail
        '99': '11d' // Thunderstorm with heavy hail
    };

    return weatherCodeMap[weatherCode.toString()] || '01d'; // Default to clear sky
}

function displayWeatherInfo(weatherData) {
    const currentTemperature = weatherData.current.temperature_2m;
    const currentWeatherCode = weatherData.current.weather_code;

    const iconCode = mapWmoCodeToIcon(currentWeatherCode);
    const iconUrl = `https://openweathermap.org/img/wn/${iconCode}.png`;

    
    document.getElementById('weatherInfo').innerHTML = `<img src="${iconUrl}" alt="Weather Icon" style="vertical-align: middle;"> Température actuelle: ${currentTemperature}°C`;
}