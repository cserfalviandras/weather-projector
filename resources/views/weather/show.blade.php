@extends('layouts.master')

@section('title', 'City')

@section('content')
    <div class="row">
        <div class="col">

            <div class="row mt-3">
                <div id="progress-container" class="progress col" style="height: 1;">
                    <div id="progress-bar" class="progress-bar" role="progressbar" style="width: 1%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>

            <div class="row">
                <div id="weather-detail-container" class="col"></div>
            </div>
            
        </div>
    </div>
<script>
    let city = @json($city);

    (function() {
        setProgress(50);

        let url = `http://localhost:8080/weather/${city}/getWeather`;

        fetch(url).then((response) => {
            if (response.ok) {
                return response;
            } else {
                throw new Error('Something went wrong');
            }
        })
        .then(response => response.json())
        .then(data => displayWeatherData(data))
        .catch((error) => {
            console.log(error)
        });

        function displayWeatherData(data) {
            setProgress(100);
            hideProgress();

            let row = document.createElement('div');
            let col = document.createElement('div');

            row.setAttribute('class', 'row');
            col.setAttribute('class', 'col');

            col.innerHTML = `
                <div class="current">
                    <div class="info">
                        <div>&nbsp;</div>
                        <h4>${city}</h4>
                        <div class="temp">
                            <small><small>TEMP:</small></small>
                            <div class="row">
                                <div class="col ml-3">${data.main.temp} <small>&deg;C</small></div>
                            </div>
                            <div class="row">
                                <div class="col ml-3">${data.main.feels_like} <small>&deg;C (feels like)</small></div>
                            </div>

                            <small><small>WIND:</small></small>
                            <div class="row">
                                <div class="col ml-3">${data.wind.speed} <small>meter/sec</small></div>
                            </div>
                        <div>&nbsp;</div>
                    </div>
                </div>
            `;

            row.appendChild(col);

            document.getElementById("weather-detail-container").appendChild(row);
        }

        function setProgress(value) {
            let progressBar = document.getElementById("progress-bar");

            progressBar.style.width = value + '%';
        }

        function hideProgress() 
        {
            let progressBar = document.getElementById("progress-bar");

            fadeOutEffect(progressBar);
        }

        function fadeOutEffect(element) {
            let fadeEffect = setInterval(function () {
                if (!element.style.opacity) {
                    element.style.opacity = 1;
                }
                if (element.style.opacity > 0) {
                    element.style.opacity -= 0.1;
                } else {
                    clearInterval(fadeEffect);
                }
            }, 200);
        }

    })();
    
</script>   
@endsection