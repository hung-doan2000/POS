<script>
  import { Doughnut } from 'vue-chartjs'

  export default {
    extends: Doughnut,
    data () {
      return {
        chartData: {
          labels: ["Cửa hàng 1", "Cửa hàng 2"],
          datasets: [{
              borderWidth: 1,
              borderColor: [
              'rgba(255,99,132,1)',
              'rgba(54, 162, 235, 1)',
              'rgba(255, 206, 86, 1)',
              'rgba(75, 192, 192, 1)'                
              ],
              backgroundColor: [
              'rgba(255, 99, 132, 0.2)',
              'rgba(54, 162, 235, 0.2)',
              'rgba(255, 206, 86, 0.2)',
              'rgba(75, 192, 192, 0.2)',
              'rgba(153, 102, 255, 0.2)',                
              ],
              data: []
            }]
        },
        options: {
          legend: {
            display: true
          },
          responsive: true,
          maintainAspectRatio: false
        }
      }
    },
    mounted () {
        let uri = "http://127.0.0.1:8000/admin/get-sale";
    this.axios.get(uri).then((response) => {
      this.sales = response.data;
      let sum1= 0;
      let sum2= 0;
      this.sales[2].forEach(element => {
          sum1+=parseInt(element);
      });
      this.sales[3].forEach(element => {
          sum2+=parseInt(element);
      });
      this.chartData.datasets[0].data.push(sum1);
      this.chartData.datasets[0].data.push(sum2);
      this.renderChart(this.chartData, this.options);
    });
    }
  }
</script>