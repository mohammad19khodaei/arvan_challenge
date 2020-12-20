<template>
  <div class="container">
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #40C5BA">
      <a class="navbar-brand" href="#">
        <img src="img/arvan.jpg" alt="" width="45" height="45">
      </a>
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
          </li>
          
        </ul>
      </div>
    </nav>
  </div>
</template>

<script>
const default_layout = "default";

export default {
  computed: {},
  data() {
    return {
      message: "Hello World",
    };
  },
};
</script>

<style scoped>
  .nav-item a {
    color: white!important;
    font-size: 17px;
  }

  .nav-item a:hover {
    color: gray!important;
  }
</style>