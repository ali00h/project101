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

</style>

<div id="app" class="container">
    <h1>Guests List:</h1>

    <section v-if="errored">
        <p>We're sorry, we're not able to retrieve this information at the moment, please try back later</p>
    </section>

    <section v-else>
        <div v-if="loading">Loading...</div>

        <div v-else>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Family</th>
                        <th>Register Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in list">
                        <td>{{ item.id }}</td>
                        <td>{{ item.firstname }}</td>
                        <td>{{ item.lastname }}</td>
                        <td>{{ item.reg_date }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </section>
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
        filters: {
            currencydecimal (value) {
                return value.toFixed(2)
            }
        },
        mounted () {
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
    })
</script>
</body>
</html>