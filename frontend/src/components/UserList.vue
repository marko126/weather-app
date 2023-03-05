<script>
export default {
  data: () => ({
    users: null,
    count: 0,
  }),

  created() {
    this.fetchData();
  },

  methods: {
    async fetchData() {
      const url = "http://localhost:8800/";
      this.users = await (await fetch(url)).json();
    },
  },
};
</script>

<template>
  <div v-if="!users">Pinging the api...</div>

  <div v-if="users">
    <h2 class="mt-3">Forecasts</h2>
    <table class="table">
      <thead class="thead-light">
        <tr>
          <th scope="col">#</th>
          <th scope="col">User</th>
          <th scope="col">Temperature (°C)</th>
          <th scope="col">Description</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users">
          <td>{{ ++count }}</td>
          <td>
            <RouterLink :to="`user/${user.id}`">{{ user.name }}</RouterLink>
          </td>
          <td>{{ user.forecast.data.temperature }}</td>
          <td>{{ user.forecast.data.description }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
