<template>
  <div>
    <div class="card card-primary mt-3">
      <div class="card-header">
        <h3 class="card-title">CUSTOMER</h3>
      </div>
      <datatable
        title=""
        :columns="tableColumns1"
        :rows="customers"
        :perPage="[5, 10]"
      >
        <th style="width: 80px" slot="thead-tr">&nbsp;</th>
        <template slot="tbody-tr" slot-scope="props">
          <td>
            <router-link
              :to="{ name: 'customer', params: { id: props.row['id'] } }"
              class="btn btn-primary btn-sm"
              href="#"
            >
              <i class="fas fa-eye"></i>
            </router-link>
          </td>
        </template>
      </datatable>
    </div>
  </div>
</template>

<script>
import DataTable from "vue-materialize-datatable";

export default {
  data() {
    return {
      customer: {},
      customers: [],
      tableColumns1: [
        {
          label: "ID",
          field: "id",
          numeric: false,
          html: false,
        },
        {
          label: "Tên khách hàng",
          field: "name",
          numeric: false,
          html: false,
        },
        {
          label: "Số điện thoại",
          field: "phone",
          numeric: false,
          html: false,
        },
        {
          label: "Email",
          field: "email",
          numeric: false,
          html: false,
        },
        {
          label: "Địa chỉ",
          field: "address",
          numeric: false,
          html: false,
        },
        {
          label: "Nhóm",
          field: "customer_group.group_name",
          numeric: false,
          html: false,
        },
        {
          label: "Đã mua",
          field: "total_money",
          numeric: false,
          html: false,
        },
      ],
    };
  },
  created() {
    let uri = "http://127.0.0.1:8000/admin/customers/list";
    this.axios.get(uri).then((response) => {
      this.customers = response.data;
      console.log(this.customers);
    });
  },
  computed: {},
  methods: {},
  components: {
    datatable: DataTable,
  },
};
</script>