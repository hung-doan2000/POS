<template>
  <div>
    <h1>Edit Brand</h1>
    <form @submit.prevent="updateBrand">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Brand name:</label>
            <input type="text" class="form-control" v-model="brand.name">
          </div>
        </div>
        </div>
        <br />
        <div class="form-group">
          <button class="btn btn-primary">Update</button>
        </div>
    </form>
  </div>
</template>

<script>
    export default {

      data() {
        return {
          brand: {}
        }
      },
      created() {
        let uri = `http://127.0.0.1:8000/api/brands/edit/${this.$route.params.id}`;
        this.axios.get(uri).then((response) => {
            this.brand = response.data;
        });
      },
      methods: {
        updateBrand() {
          let uri = `http://127.0.0.1:8000/api/brands/update/${this.$route.params.id}`;
          this.axios.put(uri, this.brand).then((response) => {
            this.$router.push({name: 'posts'});
          });
        }
      }
    }
</script>
