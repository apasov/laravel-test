<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/quasar@latest/dist/quasar.prod.css" rel="stylesheet" type="text/css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.0.0-alpha.1/axios.min.js" integrity="sha512-xIPqqrfvUAc/Cspuj7Bq0UtHNo/5qkdyngx6Vwt+tmbvTLDszzXM0G6c91LXmGrRx8KEPulT+AfOOez+TeVylg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.11.3/dayjs.min.js" integrity="sha512-Ot7ArUEhJDU0cwoBNNnWe487kjL5wAOsIYig8llY/l0P2TUFwgsAHVmrZMHsT8NGo+HwkjTJsNErS6QqIkBxDw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.11.3/locale/ru.min.js" integrity="sha512-2m7nnJFJUUe+phaiXwbL+DDnvUvb3EVtiD5KIwkTjJmNOnzdo1PTcu6bS5YyIh637b9ckqASAQzpWNiIz0FaVg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
<div id="q-app">
    <q-layout view="hHh lpR fFf">

        <q-header elevated class="bg-primary text-white">
            <q-toolbar>
                <q-btn dense flat round icon="menu" @click="toggleLeftDrawer"></q-btn>

                <q-toolbar-title>
                    <q-avatar>
                        <img alt="quasar" src="https://cdn.quasar.dev/logo-v2/svg/logo-mono-white.svg">
                    </q-avatar>
                    Объявления
                </q-toolbar-title>
            </q-toolbar>
            <q-tabs v-model="tab">
                <q-tab name="getall" icon="list" label="Список объявлений"></q-tab>
                <q-tab name="get" icon="article" label="Конкретное объявления"></q-tab>
                <q-tab name="create" icon="create" label="Создание объявления"></q-tab>
            </q-tabs>
        </q-header>

        <q-drawer show-if-above v-model="leftDrawerOpen" side="left" bordered>
            <q-item clickable v-ripple href="https://github.com/apasov">
                <q-item-section avatar>
                    <q-icon name="hub"></q-icon>
                </q-item-section>

                <q-item-section>
                    <q-item-label>Мой гитхаб</q-item-label>
                </q-item-section>
            </q-item>
            <q-item clickable v-ripple href="https://github.com/apasov/laravel-test">
                <q-item-section avatar>
                    <q-icon name="source"></q-icon>
                </q-item-section>

                <q-item-section>
                    <q-item-label>Исходный код этого задания</q-item-label>
                </q-item-section>
            </q-item>
        </q-drawer>

        <q-page-container>
            <q-tab-panels
                v-model="tab"
                animated
                transition-prev="jump-up"
                transition-next="jump-up"
            >
                <q-tab-panel name="getall">
                    <q-card style="width: 100%;max-width: 1200px;margin: 10px;">
                        <q-card-section class="bg-primary text-white">
                            <div class="text-h6">Список объявлений</div>
                        </q-card-section>

                        <q-separator></q-separator>

                        <q-card-section>
                            <q-table title="Объявления" :rows="rows" :columns="columns" :rows-per-page-options="[10, 15, 20, 25, 50, 0 ]" row-key="id"></q-table>
                        </q-card-section>

                        <q-card-section>
                            <q-btn color="primary" label="Получить список" @click="getAll"></q-btn>
                        </q-card-section>
                    </q-card>
                </q-tab-panel>

                <q-tab-panel name="get">
                    <q-card style="width: 100%;max-width: 700px;margin: 10px;">
                        <q-card-section class="bg-primary text-white">
                            <div class="text-h6">Конкретное объявления</div>
                        </q-card-section>

                        <q-separator></q-separator>

                        <q-card-section>
                            <q-list>
                                <q-item v-for="(value, key) in adResult">
                                    <q-item-section>
                                        <q-item-label>@{{ value }}</q-item-label>
                                        <q-item-label caption>@{{ keyToLabel[key] }}</q-item-label>
                                    </q-item-section>
                                </q-item>
                            </q-list>
                        </q-card-section>

                        <q-separator></q-separator>

                        <q-card-section>
                            <q-input v-model="ad" type="number" label="ID объявления"></q-input>
                            <div>
                                <q-checkbox v-model="fields" label="Включить опциональные поля"></q-checkbox>
                            </div>
                            <br/>
                            <q-btn color="primary" label="Получить объявление" @click="get"></q-btn>
                        </q-card-section>
                    </q-card>
                </q-tab-panel>

                <q-tab-panel name="create">
                    <q-card style="width: 100%;max-width: 500px;margin: 10px;">
                        <q-card-section class="bg-primary text-white">
                            <div class="text-h6">Создание объявления</div>
                        </q-card-section>

                        <q-separator></q-separator>

                        <q-card-section>
                            <q-input v-model="name" label="Название"></q-input>
                            <q-input v-model="text" type="textarea" label="Описание"></q-input>
                            <q-input v-model="price" type="number" label="Цена"></q-input>
                            <q-input v-model="foto_main" label="Главное фото"></q-input>
                            <q-input v-model="foto_2" label="Фото 2"></q-input>
                            <q-input v-model="foto_3" label="Фото 3"></q-input>
                            <br/>
                            <q-btn color="primary" label="Создать объявление" @click="create"></q-btn>
                        </q-card-section>
                    </q-card>
                </q-tab-panel>
            </q-tab-panels>

            <q-dialog v-model="errorDialog">
                <q-card>
                    <q-card-section class="row items-center">
                        <q-list>
                            <q-item-label header><h4>Ошибка!</h4></q-item-label>
                            <q-item v-for="error in errors">
                                <q-item-section avatar>
                                    <q-icon color="red" name="error" />
                                </q-item-section>
                                <q-item-section>@{{ error }}</q-item-section>
                            </q-item>
                        </q-list>
                    </q-card-section>

                    <q-card-actions align="right">
                        <q-btn flat label="Закрыть" color="primary" v-close-popup></q-btn>
                    </q-card-actions>
                </q-card>
            </q-dialog>

            <q-dialog v-model="successDialog">
                <q-card>
                    <q-card-section class="row items-center">
                        <q-list>
                            <q-item-label header><h6>Объявление успешно создано!</h6></q-item-label>
                            <q-item>
                                <q-item-section avatar>
                                    <q-icon color="primaty" name="done" />
                                </q-item-section>
                                <q-item-section>ID объявления: @{{ adID }}</q-item-section>
                            </q-item>
                        </q-list>
                    </q-card-section>

                    <q-card-actions align="right">
                        <q-btn flat label="Закрыть" color="primary" v-close-popup></q-btn>
                    </q-card-actions>
                </q-card>
            </q-dialog>
        </q-page-container>
    </q-layout>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.prod.js"></script>
<script src="https://cdn.jsdelivr.net/npm/quasar@latest/dist/quasar.umd.prod.js"></script>
<script src="https://cdn.jsdelivr.net/npm/quasar@latest/dist/lang/ru.umd.prod.js"></script>

<script>
    dayjs.locale('ru')
    const { ref } = Vue;

    const app = Vue.createApp({
        setup () {
            const leftDrawerOpen = ref(false)
            const name = ref('')
            const text = ref('')
            const price = ref(0)
            const foto_main = ref('')
            const foto_2 = ref('')
            const foto_3 = ref('')
            const errorDialog = ref(false)
            const errors = ref([])
            const successDialog = ref(false)
            const adID = ref(0)
            const ad = ref(0)
            const fields = ref(false)
            const adResult = ref({})
            const keyToLabel = {
                id: 'ID',
                name: 'Название',
                text: 'Текст',
                price: 'Цена',
                foto_main: 'Главное фото',
                foto_2: 'Фото 2',
                foto_3: 'Фото 3',
            }

            const columns = [
                { name: 'id', required: true, align: 'center', label: 'ID', field: 'id', sortable: true },
                { name: 'name', align: 'left', label: 'Название', field: 'name', sortable: true },
                { name: 'foto_main', align: 'center', label: 'Фото', field: 'foto_main', sortable: true },
                { name: 'price', align: 'center', label: 'Цена', field: 'price', sortable: true },
                { name: 'created_at', align: 'center', label: 'Дата создания', field: 'created_at', sortable: true, format: val => dayjs(val).format('D MMM H:mm') },
            ]
            const rows = ref([])

            const create = () => {
                axios.post('/api/create', {
                    name: name.value,
                    text: text.value,
                    price: price.value,
                    foto_main: foto_main.value,
                    foto_2: foto_2.value,
                    foto_3: foto_3.value,
                })
                .then((response) => {
                    adID.value = response.data
                    successDialog.value = true
                })
                .catch((error) => {
                    errors.value = []
                    Object.keys(error.response.data.errors).forEach(function(key) {
                        for (const element of error.response.data.errors[key]) {
                            errors.value.push(element)
                        }
                    })
                    errorDialog.value = true
                })
            }

            const get = () => {
                axios.get('/api/get', {
                    params: {
                        ad: ad.value,
                        fields: fields.value,
                    }
                })
                .then((response) => {
                    adResult.value = response.data[0]
                })
                .catch((error) => {
                    console.log(error)
                })
            }

            const getAll = () => {
                axios.get('/api/get/all')
                .then((response) => {
                    rows.value = response.data
                })
                .catch((error) => {
                    console.log(error)
                })
            }

            return {
                name,
                text,
                price,
                foto_main,
                foto_2,
                foto_3,
                errorDialog,
                errors,
                successDialog,
                adID,
                ad,
                fields,
                adResult,
                keyToLabel,
                columns,
                rows,
                tab: ref('getall'),
                create,
                get,
                getAll,
                leftDrawerOpen,
                toggleLeftDrawer () {
                    leftDrawerOpen.value = !leftDrawerOpen.value
                }
            }
        }
    })

    app.use(Quasar)
    Quasar.lang.set(Quasar.lang.ru)
    app.mount('#q-app')
</script>
</body>
</html>
