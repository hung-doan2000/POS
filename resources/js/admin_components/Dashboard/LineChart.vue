
<script>
import { Line } from "vue-chartjs";

export default {
  name: "LineChart",
  props: ["data","labels"],
  extends: Line,
  data() {
    return {
      sales: [],
      chartData: {
        labels: [],
        datasets: [
          {
            label: "Cửa hàng 1",
            data: [],
            fill: false,
            borderColor: "#FF3300",
            backgroundColor: "#FF3300",
            borderWidth: 1,
          },
           {
            label: "Cửa hàng 2",
            data: [],
            fill: false,
            borderColor: "#2554FF",
            backgroundColor: "#2554FF",
            borderWidth: 1,
          },
          {
            label: "Tổng",
            data: [],
            fill: false,
            borderColor: "#00CC33",
            backgroundColor: "#00CC33",
            borderWidth: 1,
          },
        ],
      },
      options: {
        scales: {
          yAxes: [
            {
              ticks: {
                beginAtZero: false,
              },
              gridLines: {
                display: true,
              },
            },
          ],
          xAxes: [
            {
              gridLines: {
                display: false,
              },
            },
          ],
        },
        legend: {
          display: true,
        },
        responsive: true,
        maintainAspectRatio: false,
      },
    };
  },
  created() {},
  mounted() {
    let uri = "http://127.0.0.1:8000/admin/get-sale";
    this.axios.get(uri).then((response) => {
      this.sales = response.data;
      // this.sales[2].forEach(element => {
      //     this.chartData.datasets[0].data.push(element.totalmoney);
      // });
      this.chartData.datasets[0].data= this.sales[2]
      // this.sales[1].forEach(element => {
      //     this.chartData.datasets[2].data.push(element);
      // });
      this.chartData.datasets[2].data = this.sales[1]
      // this.sales[3].forEach(element => {
      //     this.chartData.datasets[1].data.push(element.totalmoney);
      // });
       this.chartData.datasets[1].data = this.sales[3]
      this.sales[0].forEach(element => {
          this.chartData.labels.push(element);
      });

      this.renderChart(this.chartData, this.options);
    });
    
  },
  method(){

  }
};
</script>