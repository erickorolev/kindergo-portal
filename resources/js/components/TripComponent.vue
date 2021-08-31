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
            <div class="w-full sm:w-3/6 px-3">Откуда</div>
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
                " " +
                ("0" + (new Date(trip.date).getMonth() + 1)).substr(-2) +
                " " +
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
              Запланированное ожидание в точке “Откуда” (мин)
            </div>
            <div class="w-full sm:w-3/6 font-sans px-3">
              {{ trip.scheduled_wait_from }}
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
              Незапланированное ожидание в точке “Откуда” (мин)
            </div>
            <div class="w-full sm:w-3/6 font-sans px-3">
              {{ trip.not_scheduled_wait_from }}
            </div>
          </li>
          <li class="block sm:flex mb-6 md:w-1/2 w-full">
            <div class="font-bold w-full sm:w-3/6 px-3">
              Незапланированное ожидание в точке “Куда” (мин)
            </div>
            <div class="w-full sm:w-3/6 font-sans px-3">
              {{ trip.not_scheduled_wait_where }}
            </div>
          </li>
          <li class="block sm:flex mb-6 md:w-1/2 w-full">
            <div class="font-bold w-full sm:w-3/6 px-3">
              Стоимость парковки (руб)
            </div>
            <div class="w-full sm:w-3/6 font-sans px-3">
              {{ trip.parking_fee }}
            </div>
          </li>
          <li class="block sm:flex mb-6 md:w-1/2 w-full">
            <div class="font-bold w-full sm:w-3/6 px-3">
              Скан оплаты парковки
            </div>
            <div class="w-full sm:w-3/6 font-sans px-3">
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
          </li>
          <li class="block sm:flex mb-6 md:w-1/2 w-full">
            <div class="font-bold w-full sm:w-3/6 px-3">
              Описание
            </div>
            <div class="w-full sm:w-3/6 font-sans px-3">
              {{ trip.description }}
            </div>
          </li>
          <li class="block sm:flex mb-6 md:w-1/2 w-full">
            <div class="font-bold w-full sm:w-3/6 px-3">
              Информация о парковке
            </div>
            <div class="w-full sm:w-3/6 font-sans px-3">
              {{ trip.parking_info }}
            </div>
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
        <div class="md:mt-10 mt-8">
          <a
            @click="onNavigate('/trips/edit/' + trip.id)"
            class="cursor-pointer s-about-btn group relative inline-flex justify-center px-8 py-3 border border-transparent text-sm font-medium rounded-md text-white bg-btn-bg font-bold transition duration-500 ease-in-out hover:bg-blue-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:bg-blue-400 text-sm border border-btn-border"
          >
            Изменить
          </a>
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
  name: "TripComponent",
  components: {
    HeaderComponent
  },
  setup() {
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
    return { trip, child1, child2, child3, child4, base_url };
  },
  mounted() {
    const auth = localStorage.getItem("token");
    const vm = this;
    const currentUrl = this.$route.path;
    let children: Array<any> = [];

    axios
      .get(`/api/v1${currentUrl}`, {
        headers: {
          "Content-Type": "application/vnd.api+json",
          Accept: "application/vnd.api+json",
          Authorization: "Bearer " + auth
        }
      })
      .then(function (response: any) {
        vm.trip.id = response.data.data.id;
        vm.trip.name = response.data.data.attributes.name;
        vm.trip.where_address = response.data.data.attributes.where_address;
        vm.trip.date = response.data.data.attributes.date;
        vm.trip.time = response.data.data.attributes.time;
        vm.trip.status = response.data.data.attributes.status.description;
        vm.trip.childrens = response.data.data.attributes.childrens;
        vm.trip.duration = response.data.data.attributes.duration;
        vm.trip.distance = response.data.data.attributes.distance;
        vm.trip.parking_fee = response.data.data.attributes.parking_cost.value;
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
        vm.trip.media =
          response.data.data.attributes.media.length > 0
            ? response.data.data.attributes.media[0].url
            : "";
      })
      .catch(function (error) {
        console.log(error);
      });

    axios
      .get(`/api/v1${currentUrl}/children`, {
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
    }
  }
});
</script>
