<script>
export default {
  data: () => ({
    forecast: null,
  }),

  created() {
    this.fetchData();
  },

  methods: {
    async fetchData() {
      const url =
        "http://localhost:8800/weather/today/" + this.$route.params.id;
      this.forecast = await (await fetch(url)).json();
    },
    getIcon() {
      return (
        "https://openweathermap.org/img/wn/" +
        this.forecast.data.icon +
        "@4x.png"
      );
    },
  },
};
</script>

<style scoped>
.temp-logo {
  max-width: 160px;
}
.temp-wrapper {
  vertical-align: middle;
  display: inline-block;
}
.temp {
  font-size: 50px;
  vertical-align: middle;
}
.temp span {
  font-size: 26px;
  line-height: 55px;
  vertical-align: top;
}
.temp-feel {
  vertical-align: middle;
}
.forecast-params {
  display: flex;
  justify-content: space-between;
}
</style>

<template>
  <div v-if="!forecast">Pinging the api...</div>

  <div v-if="forecast">
    <h2 class="mt-4 mb-4 text-center">
      Current forecast for user {{ forecast.user.name }}
    </h2>

    <div class="row">
      <div class="col-md-9 m-auto">
        <div class="card">
          <div class="card-body">
            <div class="row text-muted font-13">
              <div class="col-md-6">
                Current Weather
              </div>
              <div class="col-md-6 text-right">
                {{ (new Date().toTimeString({ timeZoneName: 'short' })).split(" ")[0] }}
              </div>
            </div>
            <hr />
            <div class="row text-muted font-13">
              <div class="col-md-6">
                <div>
                  <img class="temp-logo" :src="getIcon()" />
                  <div class="temp-wrapper">
                    <div class="temp">
                      {{ forecast.data.temperature }}°<span>C</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div>
                  <div>{{ forecast.data.description }}</div>
                  <div class="temp-feel mt-3">
                    <strong>Real feel:</strong> {{ forecast.data.temperatureFeeling }}°C
                  </div>
                  <div class="mt-3">
                    <strong v-if="forecast.data.city">
                      <span>{{ forecast.data.city }},</span>
                      {{ forecast.data.country }}
                    </strong>
                  </div>
                </div>
              </div>
            </div>
            <hr />
            <div class="row">
              <div class="col-md-6">
                <div class="text-start">
                  <p class="text-muted forecast-params">
                    <strong>Wind: </strong>
                    <span class="ms-2"
                      >{{ forecast.data.windDirection }}
                      {{ forecast.data.windSpeed }} m/s</span
                    >
                  </p>
                  <p class="text-muted forecast-params">
                    <strong>Wind Gusts: </strong>
                    <span class="ms-2">{{ forecast.data.windGust }} m/s</span>
                  </p>
                  <p class="text-muted forecast-params">
                    <strong>Humidity: </strong>
                    <span class="ms-2">{{ forecast.data.humidity }}%</span>
                  </p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="text-start">
                  <p class="text-muted forecast-params">
                    <strong>Pressure: </strong>
                    <span class="ms-2">{{ forecast.data.pressure }} hPa</span>
                  </p>
                  <p class="text-muted forecast-params">
                    <strong>Cloud Cover: </strong>
                    <span class="ms-2">{{ forecast.data.cloudCover }}%</span>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
