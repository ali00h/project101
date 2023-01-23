<!doctype html>
<html lang="en">
<head>
    <title>Guests List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type = "text/javascript" src = "js/vue.js"></script>
    <script type = "text/javascript" src = "js/axios.min.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet" >
    <script src="js/bootstrap.bundle.min.js" ></script>

</head>
<body>
<style>
.progress{
    margin-bottom:20px;
}
</style>

<div id="app" class="container">
    <h1>Server Status:</h1>


    <div class="jumbotron">
        <h3>Average 1 minutes:</h3>
        <div class="progress">
            <div class="progress-bar progress-bar-striped" role="progressbar" :style="{ width: list[0] + '%' }"  aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <h3>Average 5 minutes:</h3>
        <div class="progress">
            <div class="progress-bar progress-bar-striped bg-success" role="progressbar" :style="{ width: list[1] + '%' }" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <h3>Average 15 minutes:</h3>
        <div class="progress">
            <div class="progress-bar progress-bar-striped bg-info" role="progressbar" :style="{ width: list[2] + '%' }" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
        </div>


    </div>
</div>

<script type = "text/javascript">
    new Vue({
        el: '#app',
        data () {
            return {
                list: [],
                loading: true,
            }
        },
        mounted () {
            this.callWS();
            window.setInterval(() => {
                this.callWS();
            }, 30000)
        },
        methods: {
            callWS(){
                axios
                    .get('<?php echo $_SERVER['WEBSERVICE_BASE_URL']; ?>')
                    .then(response => {
                        this.list = response.data
                    })
                    .catch(error => {
                        console.log(error)
                    })
                    .finally(() => this.loading = false)
            }
        },


    })
</script>
</body>
</html>