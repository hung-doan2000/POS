<template>
  <div>
      <h1>Brand</h1>
        <div class="row">
          <div class="col-md-10"></div>
          <div class="col-md-2">
            <router-link :to="{ name: 'create' }" class="btn btn-primary">Create Brand</router-link>
          </div>
        </div><br />

        <table class="table table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
                <tr v-for="brand in brands" :key="brand['id']">
                    <td>{{ brand['id'] }}</td>
                    <td>{{ brand['name']}}</td>
                    <td><router-link :to="{name: 'edit', params: { id: brand['id'] }}" class="btn btn-primary">Edit</router-link></td>
                    <td><button class="btn btn-danger" @click.prevent="deleteBrand(brand['id'])">Delete</button></td>
                </tr>
            </tbody>
        </table>
  </div>
</template>

<script>
  export default {
      data() {
        return {
          brands: []
        }
      },
      created() {
      let uri = 'http://127.0.0.1:8000/api/brands';
      this.axios.get(uri).then(response => {
        this.brands = response.data;
      });

    },
    methods: {
      deleteBrand(id)
      {
        let uri = `http://127.0.0.1:8000/api/brands/delete/${id}`;
        this.axios.delete(uri).then(response => {
          this.brands.splice(this.brands.indexOf(id), 1);
        });
      }
    }
  }
</script>
