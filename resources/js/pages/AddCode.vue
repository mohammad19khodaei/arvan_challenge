<template>
  <div>
    <div class="card">
      <div class="card-body">
        <div v-if="validationError.exists">
          <ul class="alert alert-danger">
            <li v-for="(value, key) in validationError.data" :key="key">
              {{ value[0] }}
            </li>
          </ul>
        </div>
        <form>
          <div class="form-group">
            <label for="code">Code</label>
            <input
              v-model="code.text"
              type="text"
              class="form-control"
              id="code"
              placeholder="Enter code"
            />
          </div>
          <div class="form-group">
            <label for="capacity">Capacity</label>
            <input
              v-model="code.capacity"
              type="number"
              class="form-control"
              id="capacity"
              placeholder="Enter capacity of code"
            />
          </div>
          <button
            type="submit"
            class="btn arvan_btn float-right"
            @click.prevent="addCode"
          >
            Submit
          </button>
        </form>
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
      code: {
        text: "",
        capacity: "",
      },
      validationError: {
        data: {},
        exists: false,
      },
    };
  },
  mounted() {
    document.title = "Add Code";
  },
  methods: {
    addCode: function () {
      this.validationError.exists = false;
      this.validationError.data = {};
      axios
        .post("/api/v1/codes", {
          code: this.code.text,
          capacity: this.code.capacity,
        })
        .then((res) => {
          this.$toasted.success("Code Added Successfully...");
          this.code.text = "";
          this.code.capacity = "";
        })
        .catch((err) => {
          this.validationError.exists = true;
          this.validationError.data = err.response.data.errors;
        });
    },
  },
};
</script>

<style scoped>
</style>