<template>
    <div class="container">


        <h1>Real-time статистика по транзакциям</h1>


        <div>
            <Bar
                :chart-options="chartOptions"
                :chart-data="chartData"
                :chart-id="chartId"
                :dataset-id-key="datasetIdKey"
                :plugins="plugins"
                :css-classes="cssClasses"
                :styles="styles"
                :width="width"
                :height="height"
            />
        </div>


        <hr>

        <div class="ps-3">
            <button type="button" class="btn btn-primary btn-lg" @click="autotest">Автотест</button>  создание 100 транзакций с рандомными данными

        </div>


        <hr>

        <div class="table-wrap">
            <table class="table table-borderless table-responsive">
                <thead>
                <tr>
                    <th></th>
                    <th class="text-muted fw-600">Получатель</th>
                    <th class="text-muted fw-600">Баланс</th>
                    <th class="text-muted fw-600">Статус</th>
                    <th class="text-muted fw-600">Сумма</th>
                    <th class="text-muted fw-600">Тип</th>
                    <th class="text-muted fw-600">Причина</th>
                    <th class="text-muted fw-600">Валюта</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>


                <tr class="align-middle alert" role="alert" v-for="transaction in transactions" :key="transaction.id">

                    <td>
                        <div class="fw-600">{{ transaction.transaction.id }}</div>
                    </td>


                    <td>
                        <div class="d-flex align-items-center">
                            <div class="img-container">
                                <img
                                    src="https://images.pexels.com/photos/2379005/pexels-photo-2379005.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940"
                                    alt="">
                            </div>
                            <div class="ps-3">
                                <div class="fw-600 pb-1">{{ transaction.recipient.email }}</div>
                                <p class="m-0 text-grey fs-09">Added: {{ transaction.transaction.created_at }}</p>
                            </div>
                        </div>
                    </td>


                    <td>
                        <div class="d-flex align-items-center">
                            <div class="ps-3">
                                <div class="fw-600">
                                    {{ transaction.recipient_wallet.value + transaction.recipient_wallet.currency }}
                                </div>
                            </div>
                        </div>
                    </td>


                    <td>

                        <div v-if="transaction.transaction.status=='in progress'"
                             class="d-inline-flex align-items-center waiting">
                            <div class="circle"></div>
                            <div class="ps-2">В процессе</div>
                        </div>

                        <div v-if="transaction.transaction.status=='success'"
                             class="d-inline-flex align-items-center active">
                            <div class="circle"></div>
                            <div class="ps-2">Успешно</div>
                        </div>


                    </td>


                    <td>
                        <div class="d-flex align-items-center">
                            <div class="ps-3">

                                <div
                                    v-if="transaction.transaction.type=='debit' && transaction.transaction.currency=='USD'"
                                    class="fw-600" style="color:#0bce0b">+{{ transaction.transaction.value }}$
                                </div>
                                <div
                                    v-if="transaction.transaction.type=='debit' && transaction.transaction.currency=='RUB'"
                                    class="fw-600" style="color:#0bce0b">+{{ transaction.transaction.value }}₽
                                </div>


                                <div
                                    v-if="transaction.transaction.type=='credit' && transaction.transaction.currency=='USD'"
                                    class="fw-600" style="color:#cc4d4d">
                                    -{{ transaction.transaction.value }}$
                                </div>

                                <div
                                    v-if="transaction.transaction.type=='credit' && transaction.transaction.currency=='RUB'"
                                    class="fw-600" style="color:#cc4d4d">
                                    -{{ transaction.transaction.value }}₽
                                </div>


                            </div>
                        </div>
                    </td>


                    <td>
                        <div class="d-flex align-items-center">
                            <div class="ps-3">
                                <div class="fw-600">{{ transaction.transaction.type }}</div>
                            </div>
                        </div>
                    </td>


                    <td>
                        <div class="d-flex align-items-center">
                            <div class="ps-3">
                                <div class="fw-600">{{ transaction.transaction.reason }}</div>
                            </div>
                        </div>
                    </td>

                    <td>
                        <div class="d-flex align-items-center">
                            <div class="ps-3">
                                <div class="fw-600">{{ transaction.transaction.currency }}</div>
                            </div>
                        </div>
                    </td>


                    <td>
                        <div class="fw-600"></div>
                    </td>


                </tr>

                </tbody>
            </table>
        </div>
    </div>


</template>

<script>

import {Bar} from 'vue-chartjs/legacy'
import {Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale} from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

export default {
    components: {Bar},
    props: {
        chartId: {
            type: String,
            default: 'bar-chart'
        },
        datasetIdKey: {
            type: String,
            default: 'label'
        },
        width: {
            type: Number,
            default: 400
        },
        height: {
            type: Number,
            default: 150
        },
        cssClasses: {
            default: '',
            type: String
        },
        styles: {
            type: Object,
            default: () => {

            }
        },
        plugins: {
            type: Object,
            default: () => {

            }
        },
    },


    data() {
        return {
            transactions: [],
            pusher: new Pusher(process.env.MIX_PUSHER_APP_KEY, {
                cluster: 'eu'
            }),
            chartData: {
                labels: [],
                datasets: [
                    {
                        label: 'Колличество транзакций',
                        backgroundColor: '#bdb407',
                        data: [],
                        height: "150xp"
                    }
                ]
            },
            chartOptions: {
                responsive: true
            }
        }
    },

    methods: {
        autotest() {
            axios.post(process.env.MIX_APP_URL + '/api/transactions/autotest');
        }
    },

    mounted() {

        //начальная установка транзакций
        // axios.get( process.env.MIX_APP_URL + '/api/transactions')
        //     .then(response => (this.transactions.push(...response.data.data)))

        //начальная установка графика
        axios.get(process.env.MIX_APP_URL + '/api/transactions/graph')
            .then(response => {
                this.chartData.labels = response.data.map((elem) => elem.hour);
                this.chartData.datasets[0].data = response.data.map((elem) => elem.count);
            })

        //Получить все данных с сокета для отрисовки событий по транзакциям
        this.pusher.subscribe('transactions').bind('events', data => {
            this.transactions.unshift(data)
        });

        //Получить все данных с сокета для отрисовки графика
        this.pusher.subscribe('transactions').bind('graph', data => {
            this.chartData.labels = data.map((elem) => elem.hour);
            this.chartData.datasets[0].data = data.map((elem) => elem.count);

        });

    }
}
</script>

<style>

@import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Roboto', sans-serif;

}

body {
    background-color: #E1F5FE;
}

.container {
    margin-top: 50px;
}

.container .table-wrap {
    overflow-x: auto;
}

.container .table-wrap::-webkit-scrollbar {
    height: 5px;
}

.container .table-wrap::-webkit-scrollbar-thumb {
    border-radius: 5px;
    background-image: linear-gradient(to right, #5D7ECD, #0C91E6);
}


.table > :not(caption) > * > * {
    padding: 2rem 0.5rem;
}

.table tbody td input[type="checkbox"] {
    appearance: none;
    width: 20px;
    height: 20px;
    background-color: #eee;
    position: relative;
    border-radius: 3px;
    cursor: pointer;
}

.table tbody td input[type="checkbox"]:after {
    position: absolute;
    width: 100%;
    height: 100%;
    font-family: "Font Awesome 5 Free";
    font-weight: 600;
    content: "\f00c";
    color: #fff;
    font-size: 15px;
    display: none;
}

.table tbody td input[type="checkbox"]:checked,
.table tbody td input[type="checkbox"]:checked:hover {
    background-color: #40bfc1;
}

.table tbody td input[type="checkbox"]:checked::after {
    display: flex;
    align-items: center;
    justify-content: center;
}

.table tbody td input[type="checkbox"]:hover {
    background-color: #ddd;
}

.table tbody td .img-container {
    width: 50px;
    height: 50px;
}

.table tbody td .img-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
}

.table tbody,
.table thead {
    background-color: #fff;
}

.table tbody tr td:nth-of-type(1) {
    text-align: center;
    min-width: 70px;
    max-width: 70px;
}

.table tbody tr td:nth-of-type(2) {
    min-width: 300px;
    max-width: 300px;
}


.table tbody tr td:nth-of-type(3) {
    min-width: 150px;
    max-width: 150px;
}

.table tbody tr td:nth-of-type(4) {
    min-width: 300px;
    max-width: 300px;
}

.table tbody tr td:nth-of-type(5) {
    min-width: 50px;
    max-width: 50px;
}

.table tbody tr {
    box-shadow: 0px 2px 3px #1f1f1f1a;
}

.table thead tr {
    border-bottom: 4px solid #E1F5FE;
}

.table tbody td .active,
.table tbody td .waiting {
    background-color: #B9F6CA;
    color: #388E3C;
    font-weight: 600;
    padding: 1px 10px;
    border-radius: 15px;
    font-size: 0.9rem;
}

.table tbody td .waiting {
    background-color: #FFECB3;
    color: #FFA000;
}

.table tbody td .active .circle,
.table tbody td .waiting .circle {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background-color: #388E3C;
}

.table tbody td .waiting .circle {
    background-color: #FFA000;
}

.table tbody td .fa-times {
    color: #D32F2F;
    font-size: 0.9rem;
}

.fw-600 {
    font-weight: 600 !important;
}

.fs-09 {
    font-size: 0.9rem;
    font-weight: 500;
}

.text-grey {
    color: #a8a8a8 !important;
}


@media (min-width: 992px) {
    .container .table-wrap {
        overflow: hidden;
    }
}
</style>
