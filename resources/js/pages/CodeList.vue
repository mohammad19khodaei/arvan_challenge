<template>
  <div>
    <div class="card">
      <div class="card-header">Add New Code</div>
      <div class="card-body">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Phone Number</th>
              <th scope="col">Code</th>
              <th scope="col">Won At</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(winner, index) in winners" :key="winner.id">
              <th scope="row">{{ index+1 }}</th>
              <td>{{ winner.phone }}</td>
              <td>{{ winner.code }}</td>
              <td>{{ winner.won_at }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
const default_layout = "default";

export default {
  computed: {},
  data() {
    return {
      winners: [],
    };
  },
  mounted() {
    document.title = "Winners List";
    this.fetchWinners();
  },
  methods: {
    fetchWinners: function () {
      axios
        .get("/api/v1/winners", { params: { per_page: 10 } })
        .then((res) => {
          this.winners = res.data.data;
        })
        .catch((err) => {});
    },
  },
};
</script>