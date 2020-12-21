<template>
  <div>
    <div class="card">
      <div class="card-header">Check Phone</div>
      <div class="card-body">
        <div v-if="validationError.exists">
          <ul class="alert alert-danger">
            <li v-for="(value, key) in validationError.data" :key="key">
              {{ value[0] }}
            </li>
          </ul>
        </div>
        <div>
          <div
            class="alert alert-success"
            role="alert"
            v-if="result.status == 'winner'"
          >
            {{ result.message }}
          </div>
          <div
            class="alert alert-danger"
            role="alert"
            v-if="result.status == 'loser'"
          >
            {{ result.message }}
          </div>
        </div>
        <form>
          <div class="form-group">
            <label for="code">Phone Number</label>
            <input
              v-model="phone"
              type="text"
              class="form-control"
              id="code"
              placeholder="Enter your phone number"
            />
          </div>
          <button
            type="submit"
            class="btn arvan_btn float-right"
            @click.prevent="checkPhone"
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
      phone: "",
      result: {
        status: "",
        message: "",
      },
      validationError: {
        data: {},
        exists: false,
      },
    };
  },
  mounted() {
    document.title = "Check Phone";
  },
  methods: {
    checkPhone: function () {
      this.result = {
        status: "",
        message: "",
      };
      this.validationError.exists = false;
      this.validationError.data = {};
      axios
        .get("/api/v1/check", { params: { phone: this.phone } })
        .then((res) => {
          this.result = res.data;
          this.phone = "";
        })
        .catch((err) => {
          this.validationError.exists = true;
          this.validationError.data = err.response.data.errors;
        });
    },
  },
};
</script>