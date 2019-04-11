<template>
    <div class="container">
        <div v-if="load">
            <img src="https://i.giphy.com/media/52qtwCtj9OLTi/giphy.webp" alt="Loading...">
        </div>

        <div v-if="!load">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-10 form-inline">
                                    <label class="col-form-label" for="zipcode">Zip Code</label>
                                    <input class="form-control" id="zipcode" type="text" v-model="zipcode">
                                </div>

                                <div class="col-md-1">
                                    <input class="btn btn-primary btn-sm" type="submit" @click="fetchWeatherZip" value="Search">
                                </div>
                            </div>

                            <div>
                                <input checked type="radio" id="cel_temp" value="c" v-model="tempDeg">
                                <label class="margin-lr-10px" for="cel_temp">Celsius</label>

                                <input type="radio" id="fah_temp" value="f" v-model="tempDeg">
                                <label class="margin-lr-10px" for="fah_temp">Fahrenheit</label>

                                <input type="radio" id="kel_temp" value="k" v-model="tempDeg">
                                <label class="margin-lr-10px"  for="kel_temp">Kelvin</label>
                            </div>
                        </div>
                        <div class="card-body">
                            <h3>Result: {{ weather.name }}</h3>
                            <table class="table table-bordered">
                                <thead>
                                <th>Min {{ convertDeg(weather.main.temp_min, tempDeg) }}</th>
                                <th>Max {{ convertDeg(weather.main.temp_max, tempDeg) }}</th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                load: false,
                tempDeg: 'c',
                weather: [],
                errors: [],
                zipcode: 4000,
                api: {
                    key: 'd0accfab9b9623a6bd4304e5e4d2f257',
                    proxy: 'https://cors-anywhere.herokuapp.com/',
                    baseUrl: 'api.openweathermap.org/data/2.5/weather?'
                }
            }
        },

        created() {
            this.load = true;
            // Auto fetch data when page loads, by default searches Brisbane's weather
            axios.get(`${this.api.proxy}${this.api.baseUrl}zip=${this.zipcode},au&APPID=${this.api.key}`)
                .then(res => {
                    this.load = false;
                    this.weather = res.data;
                })
                .catch(err => err ? null : this.error.push(err));
        },

        methods: {
            fetchWeatherZip() {
                this.load = true;
                // Fetches data after user clicks on Submit btn.
                axios.get(`${this.api.proxy}${this.api.baseUrl}zip=${this.zipcode},au&APPID=${this.api.key}`)
                    .then(res => {
                        this.load = false;
                        this.weather = res.data;
                    })
                    .catch(err => err ? null : this.error.push(err));
            },

            // By default it will display in Celsius
            convertDeg(kelvin, deg = "c") {
                if (deg.toLowerCase().localeCompare("k") === 0) return `${kelvin.toFixed(1)} K`;
                if (deg.toLowerCase().localeCompare("c") === 0) return `${parseFloat(kelvin - 273.15).toFixed(1)} °C`;
                return `${parseFloat((9 / 5) * (kelvin - 273.15) + 32).toFixed(1)} °F`;
            },
        },
    }
</script>
