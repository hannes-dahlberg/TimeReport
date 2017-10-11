<template>
    <div class="container margin-top-70">
        <div class="col-6 mx-auto jumbotron py-4">
            <h1>Add new</h1>
            <form novalidate v-on:submit.prevent="addLog">
                <div class="form-group">
                    <selectize v-model="log.route" :options="routeOptions" placeholder="Linje"></selectize>
                </div>
                <div class="form-group">
                    <selectize v-model="log.from" :options="stationOptions" placeholder="Från"></selectize>
                </div>
                <div class="form-group">
                    <selectize v-model="log.to" :options="stationOptions" placeholder="Till"></selectize>
                </div>
                <div class="row">
                    <div class="col-4">Tänkt avgång</div>
                    <div class="col-2">
                        <selectize v-model="log.when_to_leave.hour" :options="hourOptions"></selectize>
                    </div>
                    <div class="col-2">
                        <selectize v-model="log.when_to_leave.minute" :options="minuteOptions"></selectize>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">Avgick</div>
                    <div class="col-2">
                        <selectize v-model="log.left.hour" :options="hourOptions"></selectize>
                    </div>
                    <div class="col-2">
                        <selectize v-model="log.left.minute" :options="minuteOptions"></selectize>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">Tänkt att ankomma</div>
                    <div class="col-2">
                        <selectize v-model="log.when_to_arrive.hour" :options="hourOptions"></selectize>
                    </div>
                    <div class="col-2">
                        <selectize v-model="log.when_to_arrive.minute" :options="minuteOptions"></selectize>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">Ankom</div>
                    <div class="col-2">
                        <selectize v-model="log.arrived.hour" :options="hourOptions"></selectize>
                    </div>
                    <div class="col-2">
                        <selectize v-model="log.arrived.minute" :options="minuteOptions"></selectize>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Kommentar</label>
                    <textarea class="form-control" v-model="log.comment" rows="10" style="resize: none;"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Lägg till</button>
            </form>
        </div>
    </div>
</template>
<script>
    import selectize from '../components/selectize.vue'
    export default {
        components: { selectize },
        data() {
            return {
                log: {
                    route: null,
                    from: null,
                    to: null,
                    when_to_leave: { hour: null, minute: null },
                    left: { hour: null, minute: null },
                    when_to_arrive: { hour: null, minute: null },
                    arrived: { hour: null, minute: null },
                    comment: null
                },
                routeOptions: [
                    { value: 'bus_567', text: 'Buss 567' },
                    { value: 'shuttle_35', text: 'Linje 35'}
                ]
            }
        },
        computed: {
            stationOptions() {
                if(this.log.route == 'bus_567') {
                    return [
                        { value: 'stora_torget', text: 'Stora Torget' },
                        { value: 'barkarby', text: 'Barkarby station' }
                    ]
                } else if(this.log.route == 'shuttle_35') {
                    return [
                        { value: 'barkarby', text: 'Barkarby Station' },
                        { value: 'odenplan', text: 'Odenplan' }
                    ]
                }
            },
            hourOptions() {
                var returnValue = [];
                for(var a = 0; a <= 23; a++) {
                    returnValue.push({ value: a, text: a <= 9 ? ('0' + a) : a })
                }
                return returnValue
            },
            minuteOptions() {
                var returnValue = [];
                for(var a = 0; a <= 59; a++) {
                    returnValue.push({ value: a, text: a <= 9 ? ('0' + a) : a })
                }
                return returnValue
            }
        },
        mounted() {
            this.reset();
        },
        methods: {
            dateFormat(date) {
                var returnValue = ''
                returnValue += date.getFullYear() + '-'
                var month = date.getMonth()
                returnValue += (month <= 9 ? ('0' + month) : month) + '-'
                var day = date.getDate()
                returnValue += (day <= 9 ? ('0' + day) : day) + ' '
                var hour = date.getHours()
                returnValue += (hour <= 9 ? ('0' + hour) : hour) + ':'
                var minute = date.getMinutes()
                returnValue += (minute <= 9 ? ('0' + minute) : minute) + ':'
                var second = date.getSeconds()
                returnValue += second <= 9 ? ('0' + second) : second

                return returnValue
            },
            addLog() {
                var currentDate = new Date()
                currentDate.setSeconds(0)

                var when_to_leave = new Date(currentDate)
                when_to_leave.setHours(this.log.when_to_leave.hour)
                when_to_leave.setMinutes(this.log.when_to_leave.minute)

                var left = new Date(currentDate)
                left.setHours(this.log.left.hour)
                left.setMinutes(this.log.left.minute)

                var when_to_arrive = new Date(currentDate)
                when_to_arrive.setHours(this.log.when_to_arrive.hour)
                when_to_arrive.setMinutes(this.log.when_to_arrive.minute)

                var arrived = new Date(currentDate)
                arrived.setHours(this.log.arrived.hour)
                arrived.setMinutes(this.log.arrived.minute)

                this.$store.dispatch('addLog', {
                    route: this.log.route,
                    from: this.log.from,
                    to: this.log.to,
                    when_to_leave: this.dateFormat(when_to_leave),
                    left: this.dateFormat(left),
                    when_to_arrive: this.dateFormat(when_to_arrive),
                    arrived: this.dateFormat(arrived),
                    comment: this.log.comment
                }).then(() => {
                    alert('Sparat')
                }).catch(error => {
                    console.log(error)
                    alert('Något gick fel', error);
                })
            },
            reset() {
                this.log.route = null
                this.log.from = null
                this.log.to = null
                this.log.when_to_leave.hour = (new Date()).getHours()
                this.log.when_to_leave.minute = (new Date()).getMinutes()
                this.log.left.hour = (new Date()).getHours()
                this.log.left.minute = (new Date()).getMinutes()
                this.log.when_to_arrive.hour = (new Date()).getHours()
                this.log.when_to_arrive.minute = (new Date()).getMinutes()
                this.log.arrived.hour = (new Date()).getHours()
                this.log.arrived.minute = (new Date()).getMinutes()
                this.log.comment = null
            }
        }
    }
</script>