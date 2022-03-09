<template>
  <div>
    <h1>Create A Brand</h1>
    <form @submit.prevent="addBrand">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Brand name:</label>
            <input type="text" class="form-control" v-model="brand.name" />
          </div>
        </div>
      </div>
      <br />
      <div class="form-group">
        <button class="btn btn-primary">Create</button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      brand: {},
    };
  },
  methods: {
    addBrand() {
      let uri = 'http://127.0.0.1:8000/api/brands/store';
      this.axios.post(uri, this.brand).then((response) => {
        this.$router.push({ name: "posts" });
      });
      console.log(this.brand);
    },
  },
};
</script>
