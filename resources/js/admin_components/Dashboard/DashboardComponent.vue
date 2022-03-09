<template>
  <div>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <h1>Dashboard</h1>
        </div>
      </div>
      <!-- /.container-fluid -->
    </div>
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>150</h3>
                <p>Order mới</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer"
                >More info <i class="fas fa-arrow-circle-right"></i
              ></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>530312<sup style="font-size: 20px">$</sup></h3>
                <p>Doanh thu</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <router-link :to="{name:'dashboard'}" class="small-box-footer"
                >More info <i class="fas fa-arrow-circle-right"></i
              ></router-link>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>44</h3>
                <p>Khách hàng</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <router-link :to="{name:'customers-list'}" class="small-box-footer"
                >More info <i class="fas fa-arrow-circle-right"></i
              ></router-link>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>3</h3>
                <p>Đơn nhập hàng</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <router-link :to="{name:'purchases.list'}" class="small-box-footer"
                >More info <i class="fas fa-arrow-circle-right"></i
              ></router-link>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-chart-pie mr-1"> Doanh thu 12 tháng </i>
            </h3>
            <div class="card-tools">
              <ul class="nav nav-pills ml-auto">
                <li class="nav-item">
                  <button
                    class="nav-link active"
                    data-toggle="tab"
                    @click="selectLineChart()"
                  >
                    Line
                  </button>
                </li>
                <li class="nav-item">
                  <button
                    class="nav-link"
                    data-toggle="tab"
                    @click="selectDonutChart()"
                  >
                    Donut
                  </button>
                </li>
              </ul>
            </div>
          </div>
          <!-- /.card-header -->
          <line-chart v-if="saleOption == 1"></line-chart>
          <doughnut-chart v-if="saleOption == 0"></doughnut-chart>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-chart-pie mr-1">
                    5 sản phẩm bán chạy nhất tháng
                  </i>
                </h3>
                <select
                  class="form-select"
                  v-model="selectedMonth"
                  @change="changeMonth()"
                >
                  <option v-for="month in months" v-bind:value="month">
                    {{ month }}
                  </option>
                </select>
              </div>
              <!-- /.card-header -->
              <bar-chart
                v-if="loadedMonth"
                :labels="labelMonth"
                :data="valueMonth"
                label="Đã bán trong tháng"
              ></bar-chart>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-chart-pie mr-1">
                    5 sản phẩm bán chạy nhất năm
                  </i>
                </h3>
                <select
                  class="form-select"
                  v-model="selectedYear"
                  @change="changeYear()"
                >
                  <option v-for="year in years" v-bind:value="year">
                    {{ year }}
                  </option>
                </select>
              </div>
              <!-- /.card-header -->
              <bar-chart
                v-if="loadedYear"
                :labels="labelYear"
                :data="valueYear"
                label="Đã bán trong năm"
              ></bar-chart>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import LineChart from "./LineChart.vue";
import BarChart from "./BarChart.vue";
import DoughnutChart from "./DoughnutChart.vue";

export default {
  data() {
    return {
      sale: [],
      saleOption: 1,
      data: [],
      months: [],
      years: [],
      selectedMonth: null,
      selectedYear: "",
      labelMonth: [],
      labelYear: [],
      valueYear: [],
      valueMonth: [],
      loadedMonth: false,
      loadedYear: false,
    };
  },
  watch: {},
  created() {
    let uri = "http://127.0.0.1:8000/admin/get-monthyear";
    this.axios.get(uri).then((response) => {
      this.months = response.data[0];
      this.years = response.data[1];

      this.selectedMonth = this.months[0];
      this.selectedYear = this.years[0];
      console.log(response.data);
    });
    uri = "http://127.0.0.1:8000/admin/get-productmonth";
    this.axios.post(uri, { month: "12/2021" }).then((response) => {
      this.labelMonth = response.data[0];
      this.valueMonth = response.data[1];
      this.loadedMonth = true;
      console.log(this.labelMonth);
    });
    uri = "http://127.0.0.1:8000/admin/get-productyear";
    this.axios.post(uri, { year: "2021" }).then((response) => {
      console.log(response.data);
      this.labelYear = response.data[0];
      this.valueYear = response.data[1];
      this.loadedYear = true;
    });
  },
  watch: {},
  methods: {
    selectLineChart() {
      this.saleOption = 1;
    },
    selectDonutChart() {
      this.saleOption = 0;
    },
    changeMonth() {
      this.loadedMonth = false;
      let uri = "http://127.0.0.1:8000/admin/get-productmonth";
      this.axios.post(uri, { month: this.selectedMonth }).then((response) => {
        this.labelMonth = response.data[0];
        this.valueMonth = response.data[1];
        this.loadedMonth = true;
        console.log(this.labelMonth);
      });
    },
    changeYear() {
      this.loadedYear = false;
      let uri = "http://127.0.0.1:8000/admin/get-productyear";
      this.axios.post(uri, { year: this.selectedYear }).then((response) => {
        console.log(response.data);
        this.labelYear = response.data[0];
        this.valueYear = response.data[1];
        this.loadedYear = true;
      });
    },
  },
  components: {
    LineChart,
    BarChart,
    DoughnutChart,
  },
};
</script>