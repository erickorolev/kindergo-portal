<template>
  <div class="s-page overflow-hidden">
    <header-component />
    <div class="s-about py-8 pb-16">
      <div class="container mx-auto">
        <div class="border-b border-black pt-4">
          <h2 class="text-black text-2xl">Информация о поездке</h2>
        </div>
        <ul class="s-about-info text-black pt-8 flex flex-wrap -mx-3">
          <li class="block sm:flex mb-6 md:w-1/2 w-full">
            <div class="font-bold w-full sm:w-3/6 px-3">Откуда</div>
            <div class="w-full sm:w-3/6 font-sans px-3">
              {{ trip.name }}
            </div>
          </li>
          <li class="block sm:flex mb-6 md:w-1/2 w-full">
            <div class="font-bold w-full sm:w-3/6 px-3">Куда</div>
            <div class="w-full sm:w-3/6 font-sans px-3">
              {{ trip.where_address }}
            </div>
          </li>
          <li class="block sm:flex mb-6 md:w-1/2 w-full">
            <div class="font-bold w-full sm:w-3/6 px-3">Дата отправления</div>
            <div class="w-full sm:w-3/6 font-sans px-3">
              {{
                ("0" + new Date(trip.date).getDate()).substr(-2) +
                "." +
                ("0" + (new Date(trip.date).getMonth() + 1)).substr(-2) +
                "." +
                new Date(trip.date).getFullYear()
              }}
            </div>
          </li>
          <li class="block sm:flex mb-6 md:w-1/2 w-full">
            <div class="font-bold w-full sm:w-3/6 px-3">Время отправления</div>
            <div class="w-full sm:w-3/6 font-sans px-3">
              {{ trip.time.substr(0, 5) }}
            </div>
          </li>
          <li class="block sm:flex mb-6 md:w-1/2 w-full">
            <div class="font-bold w-full sm:w-3/6 px-3">Количество детей</div>
            <div class="w-full sm:w-3/6 font-sans px-3">
              {{ trip.childrens }}
            </div>
          </li>
          <li class="block sm:flex mb-6 md:w-1/2 w-full">
            <div class="font-bold w-full sm:w-3/6 px-3">Статус поездки</div>
            <div class="w-full sm:w-3/6 font-sans px-3">{{ trip.status }}</div>
          </li>
          <!-- <li class="block sm:flex mb-6 md:w-1/2 w-full">
            <div class="font-bold w-full sm:w-3/6 px-3">Статус выполнения</div>
            <div class="w-full sm:w-3/6 font-sans px-3 relative">
              <span class="cursor-pointer" @click="showExcutionStatus">
                {{excutionStatusValue}}
                <i class="fas fa-angle-down ml-2"></i>
              </span>
              <ul
                v-if="showExcution"
                class="s-header-list list-none m-0 border border-main-gray-light flex justify-start rounded-lg bg-white items-stretch flex active"
              >
                <li class="border-r border-main-gray-light rounded-l" @click="excutionStatus('Не подтверждена')">
                  Не подтверждена
                </li>
                <li class="border-r border-main-gray-light" @click="excutionStatus('Подтверждаю')">
                  Подтверждаю
                </li>
                <li class="border-r border-main-gray-light" @click="excutionStatus('Опаздываю')">
                  Опаздываю
                </li>
                <li class="border-r border-main-gray-light" @click="excutionStatus('На месте')">
                  На месте
                </li>
                <li class="border-r border-main-gray-light" @click="excutionStatus('Нет ребенка')">
                  Нет ребенка
                </li>
                <li class="border-r border-main-gray-light" @click="excutionStatus('Забрала ребенка')">
                  Забрала ребенка
                </li>
                <li class="border-r border-main-gray-light" @click="excutionStatus('Что-то случилось')">
                  Что-то случилось
                </li>
                <li class="border-r border-main-gray-light" @click="excutionStatus('Привезла ребенка')">
                  Привезла ребенка
                </li>
                <li class="border-r border-main-gray-light" @click="excutionStatus('Завершить поездку')">
                  Завершить поездку
                </li>
              </ul>              
            </div>
          </li> -->
          <li class="block sm:flex md:w-1/2 w-full">
            <div class="font-bold w-full sm:w-3/6 px-3"></div>
            <div class="w-full sm:w-3/6 font-sans px-3"></div>
          </li>
          <li class="block sm:flex mb-6 md:w-1/2 w-full">
            <div class="font-bold w-full sm:w-3/6 px-3">
              Длительность маршрута <br />(мин)
            </div>
            <div class="w-full sm:w-3/6 font-sans px-3">
              {{ trip.duration }}
            </div>
          </li>
          <li class="block sm:flex mb-6 md:w-1/2 w-full">
            <div class="font-bold w-full sm:w-3/6 px-3">
              Дистанция маршрута <br />(мин)
            </div>
            <div class="w-full sm:w-3/6 font-sans px-3">
              {{ trip.distance }}
            </div>
          </li>
          <li class="block sm:flex mb-6 md:w-1/2 w-full">
            <div class="font-bold w-full sm:w-3/6 px-3">
              Запланированное ожидание в точке “Куда” (мин)
            </div>
            <div class="w-full sm:w-3/6 font-sans px-3">
              {{ trip.scheduled_wait_where }}
            </div>
          </li>
          <li class="block sm:flex mb-6 md:w-1/2 w-full">
            <div class="font-bold w-full sm:w-3/6 px-3">
              Запланированное ожидание в точке “Откуда” (мин)
            </div>
            <div class="w-full sm:w-3/6 font-sans px-3">
              {{ trip.scheduled_wait_from }}
            </div>
          </li>
          <li class="block sm:flex mb-6 md:w-1/2 w-full">
            <div class="font-bold w-full sm:w-3/6 px-3">
              Незапланированное ожидание в точке “Куда” (мин)
            </div>
            <div class="w-full sm:w-3/6 font-sans px-3">
              <div class="input inline-flex w-full">
                <input
                  type="text"
                  name="timewaitto"
                  class="block border border-main-gray outline-none px-2 h-8 text-black font-sans w-full"
                  v-model="trip.not_scheduled_wait_where"
                />
              </div>
            </div>
          </li>
          <li class="block sm:flex mb-6 md:w-1/2 w-full">
            <div class="font-bold w-full sm:w-3/6 px-3">
              Незапланированное ожидание в точке “Откуда” (мин)
            </div>
            <div class="w-full sm:w-3/6 font-sans px-3">
              <div class="input inline-flex w-full">
                <input
                  type="text"
                  name="timewaitfrom"
                  class="block border border-main-gray outline-none px-2 h-8 text-black font-sans w-full"
                  v-model="trip.not_scheduled_wait_from"
                />
              </div>
            </div>
          </li>
          <li class="block sm:flex mb-6 md:w-1/2 w-full">
            <div class="font-bold w-full sm:w-3/6 px-3">
              Стоимость парковки (руб)
            </div>
            <div class="w-full sm:w-3/6 font-sans px-3">
              <div class="input inline-flex w-full">
                <input
                  type="text"
                  name="timewaitfrom"
                  class="block border border-main-gray outline-none px-2 h-8 text-black font-sans w-full"
                  v-model="trip.parking_fee"
                />
              </div>
            </div>
          </li>
          <li class="block sm:flex mb-6 md:w-1/2 w-full">
            <div class="font-bold w-full sm:w-3/6 px-3">
              Скан оплаты парковки
            </div>
            <div class="w-full sm:w-3/6 font-sans px-3">
              <div class="s-about-avatar pr-4">
                <div class="flex">
                  <form action="#">
                    <div class="input-file-container">
                      <input
                        class="input-file"
                        id="my-file"
                        type="file"
                        @change="fileUpload($event)"
                      />
                      <label
                        tabindex="0"
                        for="my-file"
                        class="input-file-trigger"
                        ><img
                          src="../../img/icon-edit.png"
                          alt="img"
                          width="20"
                      /></label>
                    </div>
                  </form>
                </div>
                <div class="py-3" v-if="fileid !== ''">
                  <span>файл выбран</span>
                  <i
                    class="fas fa-times pl-2 cursor-pointer"
                    @click="removefile"
                  ></i>
                </div>
                <div>
                  <a
                    v-if="trip.media !== ''"
                    :href="trip.media"
                    target="blank"
                    class="cursor-pointer block w-full max-w-15"
                    >{{
                      trip.media.split("/")[trip.media.split("/").length - 1]
                    }}</a
                  >
                </div>
              </div>
            </div>
          </li>
          <li class="block sm:flex mb-6 md:w-1/2 w-full">
            <div class="font-bold w-full sm:w-3/6 px-3">
              Доход <br />сопровождающего
            </div>
            <div class="w-full sm:w-3/6 font-sans px-3">
              {{ trip.attendant_income }}
            </div>
          </li>
          <li class="block sm:flex md:w-1/2 w-full">
            <div class="font-bold w-full sm:w-3/6 px-3"></div>
            <div class="w-full sm:w-3/6 font-sans px-3"></div>
          </li>
          <li class="block sm:flex mb-6 md:w-1/2 w-full">
            <div class="font-bold w-full sm:w-3/6 px-3">
              Описание
            </div>
            <div class="w-full sm:w-3/6 font-sans px-3">
              {{ trip.description }}
            </div>
          </li>
          <li class="block sm:flex md:w-1/2 w-full">
            <div class="font-bold w-full sm:w-3/6 px-3"></div>
            <div class="w-full sm:w-3/6 font-sans px-3"></div>
          </li>
          <li class="block sm:flex mb-6 md:w-1/2 w-full">
            <div class="font-bold w-full sm:w-3/6 px-3">
              Информация о парковке
            </div>
            <div class="w-full sm:w-3/6 font-sans px-3">
              {{ trip.parking_info }}
            </div>
          </li>
          <li class="block sm:flex md:w-1/2 w-full">
            <div class="font-bold w-full sm:w-3/6 px-3"></div>
            <div class="w-full sm:w-3/6 font-sans px-3"></div>
          </li>

          <li class="block sm:flex mb-6 md:w-1/2 w-full">
            <div class="font-bold w-full sm:w-3/6 px-3">
              Ребенок 1
            </div>
            <div class="w-full sm:w-3/6 font-sans px-3">
              <a
                @click="onNavigate(child1.url.replace(base_url, ''))"
                class="cursor-pointer text-breadcrumb-blue border-b border-transparent hover:border-breadcrumb-blue transition duration-500 ease-in-out"
                >{{ child1.name }}</a
              >
            </div>
          </li>
          <li class="block sm:flex mb-6 md:w-1/2 w-full">
            <div class="font-bold w-full sm:w-3/6 px-3">
              Ребенок 2
            </div>
            <div class="w-full sm:w-3/6 font-sans px-3">
              <a
                @click="onNavigate(child2.url.replace(base_url, ''))"
                class="cursor-pointer text-breadcrumb-blue border-b border-transparent hover:border-breadcrumb-blue transition duration-500 ease-in-out"
                >{{ child2.name }}</a
              >
            </div>
          </li>
          <li class="block sm:flex mb-6 md:w-1/2 w-full">
            <div class="font-bold w-full sm:w-3/6 px-3">
              Ребенок 3
            </div>
            <div class="w-full sm:w-3/6 font-sans px-3">
              <a
                @click="onNavigate(child3.url.replace(base_url, ''))"
                class="cursor-pointer text-breadcrumb-blue border-b border-transparent hover:border-breadcrumb-blue transition duration-500 ease-in-out"
                >{{ child3.name }}</a
              >
            </div>
          </li>
          <li class="block sm:flex mb-6 md:w-1/2 w-full">
            <div class="font-bold w-full sm:w-3/6 px-3">
              Ребенок 4
            </div>
            <div class="w-full sm:w-3/6 font-sans px-3">
              <a
                @click="onNavigate(child4.url.replace(base_url, ''))"
                class="cursor-pointer text-breadcrumb-blue border-b border-transparent hover:border-breadcrumb-blue transition duration-500 ease-in-out"
                >{{ child4.name }}</a
              >
            </div>
          </li>
        </ul>
        <div class="md:mt-10 mt-6 flex">
          <div class="mr-8">
            <a
              @click="update"
              class="cursor-pointer s-about-btn group relative inline-flex justify-center w-28 px-4 py-3 border border-transparent text-sm font-medium rounded-md text-white bg-btn-green font-bold transition duration-500 ease-in-out hover:bg-btn-green-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:bg-btn-green-hover text-sm border border-btn-border-green"
            >
              Сохранить
            </a>
          </div>
          <div>
            <a
              @click="onNavigate('/trips/' + id)"
              class="cursor-pointer s-about-btn group relative inline-flex justify-center w-28 px-4 py-3 border border-transparent text-sm font-medium rounded-md text-white bg-btn-bg font-bold transition duration-500 ease-in-out hover:bg-blue-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:bg-blue-400 text-sm border border-btn-border"
            >
              Отмена
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref } from "vue";
import HeaderComponent from "./HeaderComponent.vue";
import axios from "axios";
import { Trip, Children } from "../types/trips";
import { base_url } from "../data";

export default defineComponent({
  name: "TripEditComponent",
  components: {
    HeaderComponent
  },
  setup() {
    const showExcution = ref<Boolean>(false);
    const excutionStatusValue = ref<String>("Не подтверждена");
    const id = ref<String>("");
    const trip = ref<Trip>({
      id: "",
      name: "",
      where_address: "",
      date: "",
      time: "",
      status: "",
      childrens: 0,
      duration: 0,
      distance: 0,
      scheduled_wait_where: 0,
      scheduled_wait_from: 0,
      not_scheduled_wait_where: 0,
      not_scheduled_wait_from: 0,
      parking_fee: 0,
      attendant_income: 0,
      scan_payment: "",
      description: "",
      parking_info: "",
      media: ""
    });
    const child1 = ref<Children>({
      name: "",
      url: ""
    });
    const child2 = ref<Children>({
      name: "",
      url: ""
    });
    const child3 = ref<Children>({
      name: "",
      url: ""
    });
    const child4 = ref<Children>({
      name: "",
      url: ""
    });
    const status_value = ref<String>("");
    const fileid = ref<string>("");
    return {
      showExcution,
      excutionStatusValue,
      id,
      trip,
      child1,
      child2,
      child3,
      child4,
      status_value,
      fileid,
      base_url
    };
  },
  mounted() {
    const auth = localStorage.getItem("token");
    const vm = this;
    const currentUrl = this.$route.path.split('/');
    this.id = currentUrl[currentUrl.length - 1];
    let children: Array<any> = [];

    axios
      .get(`/api/v1/trips/${this.id}`, {
        headers: {
          "Content-Type": "application/vnd.api+json",
          Accept: "application/vnd.api+json",
          Authorization: "Bearer " + auth
        }
      })
      .then(function (response: any) {
        vm.trip.name = response.data.data.attributes.name;
        vm.trip.where_address = response.data.data.attributes.where_address;
        vm.trip.date = response.data.data.attributes.date;
        vm.trip.time = response.data.data.attributes.time;
        vm.trip.status = response.data.data.attributes.status.description;
        vm.trip.childrens = response.data.data.attributes.childrens;
        vm.trip.duration = response.data.data.attributes.duration;
        vm.trip.distance = response.data.data.attributes.distance;
        vm.trip.parking_fee = response.data.data.attributes.parking_cost?response.data.data.attributes.parking_cost.value:"";
        vm.trip.attendant_income =
          response.data.data.attributes.attendant_income?response.data.data.attributes.attendant_income.value:"";
        vm.trip.scheduled_wait_where =
          response.data.data.attributes.scheduled_wait_where;
        vm.trip.scheduled_wait_from =
          response.data.data.attributes.scheduled_wait_from;
        vm.trip.not_scheduled_wait_where =
          response.data.data.attributes.not_scheduled_wait_where;
        vm.trip.not_scheduled_wait_from =
          response.data.data.attributes.not_scheduled_wait_from;
        vm.trip.description = response.data.data.attributes.description;
        vm.trip.parking_info = response.data.data.attributes.parking_info;
        vm.status_value = response.data.data.attributes.status?response.data.data.attributes.status.value:"";
        vm.trip.media =
          response.data.data.attributes.media.length > 0
            ? response.data.data.attributes.media[0].url
            : "";
      })
      .catch(function (error) {
        console.log(error);
      });

    axios
      .get(`/api/v1/trips/${this.id}/children`, {
        headers: {
          "Content-Type": "application/vnd.api+json",
          Accept: "application/vnd.api+json",
          Authorization: "Bearer " + auth
        }
      })
      .then(function (response: any) {
        response.data.data.forEach((item: any) => {
          children.push(item);
        });
        vm.child1 =
          children.length > 0
            ? {
                name:
                  children[0].attributes.firstname +
                  " " +
                  children[0].attributes.lastname,
                url: children[0].links.self
              }
            : { name: "", url: "" };
        vm.child2 =
          children.length > 1
            ? {
                name:
                  children[1].attributes.firstname +
                  " " +
                  children[1].attributes.lastname,
                url: children[1].links.self
              }
            : { name: "", url: "" };
        vm.child3 =
          children.length > 3
            ? {
                name:
                  children[3].attributes.firstname +
                  " " +
                  children[3].attributes.lastname,
                url: children[3].links.self
              }
            : { name: "", url: "" };
        vm.child4 =
          children.length > 4
            ? {
                name:
                  children[4].attributes.firstname +
                  " " +
                  children[4].attributes.lastname,
                url: children[4].links.self
              }
            : { name: "", url: "" };
      })
      .catch(function (error) {
        console.log(error);
      });
  },
  methods: {
    onNavigate(url: string): void {
      this.$router.push(url);
    },
    update(): void {      
      const vm = this;
      const auth = localStorage.getItem("token");
      const body = {
        data: {
          type: "trips",
          id: this.id,
          attributes: {
            name: this.trip.name,
            where_address: this.trip.where_address,
            date:
              new Date(this.trip.date).getFullYear() +
              "-" +
              ("0" + (new Date(this.trip.date).getMonth() + 1)).substr(-2) +
              "-" +
              ("0" + new Date(this.trip.date).getDate()).substr(-2),
            time: this.trip.time,
            childrens: this.trip.childrens,
            duration: this.trip.duration,
            distance: this.trip.distance,
            status: this.trip.status,
            scheduled_wait_where: this.trip.scheduled_wait_where,
            scheduled_wait_from: this.trip.scheduled_wait_from,
            not_scheduled_wait_where: this.trip.not_scheduled_wait_where,
            not_scheduled_wait_from: this.trip.not_scheduled_wait_from,
            parking_cost: this.trip.parking_fee,
            attendant_income: this.trip.attendant_income,
            file: this.fileid
          }
        }
      };
      axios
        .patch("/api/v1/trips/" + this.id, body, {
          headers: {
            "Content-Type": "application/vnd.api+json",
            Accept: "application/vnd.api+json",
            Authorization: "Bearer " + auth
          }
        })
        .then(function (response: any) {
          vm.$router.push("/trips/" + vm.id);
        })
        .catch(function (error) {
          const msg = error.response.data.message;
          if (msg == 'Unable to parse URI: http://') {
            vm.$router.push("/profile");
          } else {
            alert(msg);
          }  
        });
    },
    fileUpload(e: any) {
      const vm = this;
      const auth = localStorage.getItem("token");
      let requestData = new FormData();
      requestData.append("file_upload", e.target.files[0]);

      axios
        .post("/api/v1/upload", requestData, {
          headers: {
            "Content-Type": "application/vnd.api+json",
            Accept: "application/vnd.api+json",
            Authorization: "Bearer " + auth
          }
        })
        .then((res: any) => {
          vm.fileid = res.data;
          console.log(res.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    removefile() {
      this.fileid = "";
    },
    showExcutionStatus() {
      this.showExcution = !this.showExcution;
    },
    excutionStatus(value: string): void {
      this.excutionStatusValue = value;
      this.showExcution = false;
    }
  }
});
</script>
<style scoped lang="scss">
  .s-header-list.active {
    position: absolute;
    left: 15px;
    top: 36px;
    display: block;
    z-index: 999;
    li {
      padding: 10px 30px;
      border-bottom: 1px solid;
    }    
  }
</style>
