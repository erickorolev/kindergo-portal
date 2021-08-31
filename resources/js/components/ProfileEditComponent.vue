<template>
  <div class="s-page overflow-hidden">
    <header-component />
    <div class="s-about py-8 pb-20">
      <div class="container mx-auto">
        <div class="border-b border-black">
          <h2 class="text-black text-2xl">Информация вашего профиля</h2>
        </div>
        <div class="flex pt-8 justify-start flex-wrap md:flex-nowrap">
          <div class="w-full lg:w-1/2 md:w-4/5 order-2 md:order-1 pt-6 md:pt-0">
            <ul class="s-about-info text-black max-w-2xl sm:pr-6">
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">Имя</div>
                <div class="w-full sm:w-3/5 md:w-3/6">
                  <div class="text flex items-center font-sans">
                    {{ firstname }}
                  </div>
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">Фамилия</div>
                <div class="w-full sm:w-3/5 md:w-3/6 font-sans">
                  {{ lastname }}
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">Отчество</div>
                <div class="w-full sm:w-3/5 md:w-3/6 font-sans">
                  {{ middle_name }}
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">E-mail</div>
                <div class="w-full sm:w-3/5 md:w-3/6 font-sans">
                  {{ email }}
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">Телефон</div>
                <div class="w-full sm:w-3/5 md:w-3/6 font-sans">
                  {{ phone }}
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">Другой тел</div>
                <div class="w-full sm:w-3/5 md:w-3/6">
                  <div class="input inline-flex w-full">
                    <input
                      type="text"
                      name="phone2"
                      class="block border border-main-gray outline-none px-2 h-8 text-black font-sans w-full"
                      v-model="otherphone"
                    />
                  </div>
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">Пол</div>
                <div class="w-full sm:w-3/5 md:w-3/6 font-sans">
                  {{ gender }}
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">Категория</div>
                <div class="w-full sm:w-3/5 md:w-3/6 font-sans">
                  {{ attendant_category }}
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">Статус</div>
                <div class="w-full sm:w-3/5 md:w-3/6 font-sans">
                  {{ attendant_status }}
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">
                  Дата трудоустройства
                </div>
                <div class="w-full sm:w-3/5 md:w-3/6 font-sans">
                  {{
                    ("0" + new Date(attendant_hired).getDate()).substr(-2) +
                    "." +
                    ("0" + (new Date(attendant_hired).getMonth() + 1)).substr(
                      -2
                    ) +
                    "." +
                    new Date(attendant_hired).getFullYear()
                  }}
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">
                  День рождения
                </div>
                <div class="w-full sm:w-3/5 md:w-3/6 font-sans">
                  {{
                    ("0" + new Date(birthday).getDate()).substr(-2) +
                    "." +
                    ("0" + (new Date(birthday).getMonth() + 1)).substr(-2) +
                    "." +
                    new Date(birthday).getFullYear()
                  }}
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="italic text-black text-lg">Адрес регистрации</div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">Индекс</div>
                <div class="w-full sm:w-3/5 md:w-3/6 font-sans">
                  {{ mailingzip }}
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">Страна</div>
                <div class="w-full sm:w-3/5 md:w-3/6 font-sans">
                  {{ mailingcountry }}
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">Область</div>
                <div class="w-full sm:w-3/5 md:w-3/6 font-sans">
                  {{ mailingstate }}
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">Город</div>
                <div class="w-full sm:w-3/5 md:w-3/6 font-sans">
                  {{ mailingcity }}
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">
                  Улица, дом, квартира
                </div>
                <div class="w-full sm:w-3/5 md:w-3/6 font-sans">
                  {{ mailingstreet }}
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="italic text-black text-lg">Адрес проживания</div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">Индекс</div>
                <div class="w-full sm:w-3/5 md:w-3/6">
                  <div class="input inline-flex w-full">
                    <input
                      type="text"
                      name="postindex"
                      class="block border border-main-gray outline-none px-2 h-8 text-black font-sans w-full"
                      v-model="otherzip"
                    />
                  </div>
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">Страна</div>
                <div class="w-full sm:w-3/5 md:w-3/6">
                  <div class="input inline-flex w-full">
                    <input
                      type="text"
                      name="country"
                      class="block border border-main-gray outline-none px-2 h-8 text-black font-sans w-full"
                      v-model="othercountry"
                    />
                  </div>
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">Область</div>
                <div class="w-full sm:w-3/5 md:w-3/6">
                  <div class="input inline-flex w-full">
                    <input
                      type="text"
                      name="region"
                      class="block border border-main-gray outline-none px-2 h-8 text-black font-sans w-full"
                      v-model="otherstate"
                    />
                  </div>
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">Город</div>
                <div class="w-full sm:w-3/5 md:w-3/6">
                  <div class="input inline-flex w-full">
                    <input
                      type="text"
                      name="city"
                      class="block border border-main-gray outline-none px-2 h-8 text-black font-sans w-full"
                      v-model="othercity"
                    />
                  </div>
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">
                  Улица, дом, квартира
                </div>
                <div class="w-full sm:w-3/5 md:w-3/6">
                  <div class="input inline-flex w-full">
                    <input
                      type="text"
                      name="street"
                      class="block border border-main-gray outline-none px-2 h-8 text-black font-sans w-full"
                      v-model="otherstreet"
                    />
                  </div>
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">
                  Станция метро
                </div>
                <div class="w-full sm:w-3/5 md:w-3/6">
                  <div class="input inline-flex w-full">
                    <input
                      type="text"
                      name="metro"
                      class="block border border-main-gray outline-none px-2 h-8 text-black font-sans w-full"
                      v-model="metro_station"
                    />
                  </div>
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">
                  Марка автомобиля
                </div>
                <div class="w-full sm:w-3/5 md:w-3/6">
                  <div class="input inline-flex w-full">
                    <input
                      type="text"
                      name="modelcar"
                      class="block border border-main-gray outline-none px-2 h-8 text-black font-sans w-full"
                    />
                  </div>
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">
                  Год автомобиля
                </div>
                <div class="w-full sm:w-3/5 md:w-3/6">
                  <div class="input inline-flex w-full">
                    <input
                      type="text"
                      name="yearcar"
                      class="block border border-main-gray outline-none px-2 h-8 text-black font-sans w-full"
                      v-model="car_year"
                    />
                  </div>
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">
                  Цвет автомобиля
                </div>
                <div class="w-full sm:w-3/5 md:w-3/6">
                  <div class="input inline-flex w-full">
                    <input
                      type="text"
                      name="colorcar"
                      class="block border border-main-gray outline-none px-2 h-8 text-black font-sans w-full"
                      v-model="car_color"
                    />
                  </div>
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">
                  Тел куратора
                </div>
                <div class="w-full sm:w-3/5 md:w-3/6 font-sans">
                  {{ otherzip }}
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">
                  Платежные данные
                </div>
                <div class="w-full sm:w-3/5 md:w-3/6">
                  <div class="input inline-flex w-full">
                    <textarea
                      name="payment"
                      cols="30"
                      rows="10"
                      class="block w-full border-0 outline-none h-28 font-sans border border-main-gray p-2.5"
                      v-model="payment_data"
                    ></textarea>
                  </div>
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">Анкета</div>
                <div class="w-full sm:w-3/5 md:w-3/6">
                  <div class="input inline-flex w-full">
                    <textarea
                      name="profiledata"
                      cols="30"
                      rows="10"
                      class="block w-full border-0 outline-none h-80 font-sans border border-main-gray p-2.5"
                      v-model="resume"
                    ></textarea>
                  </div>
                </div>
              </li>
            </ul>
            <div class="md:mt-10 mt-8 flex">
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
                  @click="onNavigate('/profile')"
                  class="cursor-pointer s-about-btn group relative inline-flex justify-center w-28 px-4 py-3 border border-transparent text-sm font-medium rounded-md text-white bg-btn-bg font-bold transition duration-500 ease-in-out hover:bg-blue-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:bg-blue-400 text-sm border border-btn-border"
                >
                  Отмена
                </a>
              </div>
            </div>
          </div>
          <div class="w-full lg:w-1/2 md:w-1/5 order-1 md:order-2">
            <div class="s-about-avatar pr-4">
              <div class="flex">
                <div class="font-bold pb-4 text-black mr-4">Фотография</div>
                <form action="#">
                  <div class="input-file-container">
                    <input
                      class="input-file"
                      id="my-file"
                      type="file"
                      @change="fileUpload($event)"
                    />
                    <label tabindex="0" for="my-file" class="input-file-trigger"
                      ><img src="../../img/icon-edit.png" alt="img" width="20"
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
              <img
                v-if="media !== ''"
                :src="media"
                alt="img"
                class="block w-full max-w-15"
              />
            </div>
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
import { base_url } from "../data";

export default defineComponent({
  name: "ProfileEditComponent",
  components: {
    HeaderComponent
  },
  setup() {
    const id = ref<string>("");
    const firstname = ref<string>("");
    const lastname = ref<string>("");
    const middle_name = ref<string>("");
    const email = ref<string>("");
    const phone = ref<string>("");
    const otherphone = ref<string>("");
    const gender = ref<string>("");
    const gender_value = ref<string>("");
    const attendant_category = ref<string>("");
    const attendant_category_value = ref<string>("");
    const attendant_status = ref<string>("");
    const attendant_status_value = ref<string>("");
    const attendant_hired = ref<string>("");
    const birthday = ref<string>("");
    const mailingzip = ref<number>(0);
    const mailingcountry = ref<string>("");
    const mailingstate = ref<string>("");
    const mailingcity = ref<string>("");
    const mailingstreet = ref<string>("");
    const otherzip = ref<number>(0);
    const othercountry = ref<string>("");
    const otherstate = ref<string>("");
    const othercity = ref<string>("");
    const otherstreet = ref<string>("");
    const metro_station = ref<string>("");
    const car_model = ref<string>("");
    const car_year = ref<number>(0);
    const car_color = ref<string>("");
    const resume = ref<string>("");
    const payment_data = ref<string>("");
    const media = ref<string>("");
    const fileid = ref<string>("");

    return {
      id,
      firstname,
      lastname,
      middle_name,
      email,
      gender,
      gender_value,
      phone,
      otherphone,
      attendant_category,
      attendant_category_value,
      attendant_status,
      attendant_status_value,
      attendant_hired,
      birthday,
      mailingzip,
      mailingcountry,
      mailingstate,
      mailingcity,
      mailingstreet,
      otherzip,
      othercountry,
      otherstate,
      othercity,
      otherstreet,
      metro_station,
      car_model,
      car_year,
      car_color,
      resume,
      payment_data,
      media,
      fileid,
      base_url
    };
  },
  mounted() {
    const auth = localStorage.getItem("token");
    const vm = this;
    const currentUrl = this.$route.path;

    axios
      .get("/api/v1/users/me", {
        headers: {
          "Content-Type": "application/vnd.api+json",
          Accept: "application/vnd.api+json",
          Authorization: "Bearer " + auth
        }
      })
      .then(function (response: any) {
        vm.id = response.data.data.id;
        vm.firstname = response.data.data.attributes.firstname;
        vm.lastname = response.data.data.attributes.lastname;
        vm.middle_name = response.data.data.attributes.middle_name;
        vm.email = response.data.data.attributes.email;
        vm.phone = response.data.data.attributes.phone;
        vm.otherphone = response.data.data.attributes.otherphone;
        vm.gender = response.data.data.attributes.gender.description;
        vm.gender_value = response.data.data.attributes.gender.value;
        vm.attendant_category =
          response.data.data.attributes.attendant_category.description;
        vm.attendant_category_value =
          response.data.data.attributes.attendant_category.value;
        vm.attendant_status =
          response.data.data.attributes.attendant_status.description;
        vm.attendant_status_value =
          response.data.data.attributes.attendant_status.value;
        vm.attendant_hired = response.data.data.attributes.attendant_hired;
        vm.birthday = response.data.data.attributes.birthday;
        vm.mailingzip = response.data.data.attributes.mailingzip;
        vm.mailingstate = response.data.data.attributes.mailingstate;
        vm.mailingcountry = response.data.data.attributes.mailingcountry;
        vm.mailingcity = response.data.data.attributes.mailingcity;
        vm.mailingstreet = response.data.data.attributes.mailingstreet;
        vm.otherzip = response.data.data.attributes.otherzip;
        vm.otherstate = response.data.data.attributes.otherstate;
        vm.othercountry = response.data.data.attributes.othercountry;
        vm.othercity = response.data.data.attributes.othercity;
        vm.otherstreet = response.data.data.attributes.otherstreet;
        vm.metro_station = response.data.data.attributes.metro_station;
        vm.car_model = response.data.data.attributes.car_model;
        vm.car_year = response.data.data.attributes.car_year;
        vm.car_color = response.data.data.attributes.car_color;
        vm.resume = response.data.data.attributes.resume;
        vm.payment_data = response.data.data.attributes.payment_data;
        vm.media =
          response.data.data.attributes.media.length > 0
            ? response.data.data.attributes.media[0].url
            : "";
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
          type: "users",
          id: this.id,
          attributes: {
            email: this.email,
            firstname: this.firstname,
            lastname: this.lastname,
            middle_name: this.middle_name,
            phone: this.phone,
            gender: this.gender_value,
            otherphone: this.otherphone,
            attendant_category: this.attendant_category_value,
            attendant_status: this.attendant_status_value,
            attendant_hired:
              new Date(this.attendant_hired).getFullYear() +
              "-" +
              ("0" + (new Date(this.attendant_hired).getMonth() + 1)).substr(
                -2
              ) +
              "-" +
              ("0" + new Date(this.attendant_hired).getDate()).substr(-2),
            birthday:
              new Date(this.birthday).getFullYear() +
              "-" +
              ("0" + (new Date(this.birthday).getMonth() + 1)).substr(-2) +
              "-" +
              ("0" + new Date(this.birthday).getDate()).substr(-2),
            mailingzip: this.mailingzip,
            mailingstate: this.mailingstate,
            mailingcountry: this.mailingcountry,
            mailingcity: this.mailingcity,
            mailingstreet: this.mailingstreet,
            otherzip: this.otherzip,
            otherstate: this.otherstate,
            othercountry: this.othercountry,
            othercity: this.othercity,
            otherstreet: this.otherstreet,
            metro_station: this.metro_station,
            car_model: this.car_model,
            car_year: this.car_year,
            car_color: this.car_color,
            resume: this.resume,
            payment_data: this.payment_data,
            file: this.fileid
          }
        }
      };
      axios
        .patch("/api/v1/users/" + this.id, body, {
          headers: {
            "Content-Type": "application/vnd.api+json",
            Accept: "application/vnd.api+json",
            Authorization: "Bearer " + auth
          }
        })
        .then(function (response: any) {
          vm.$router.push("/profile");
        })
        .catch(function (error) {
          console.log(error.response.data);
          vm.$router.push("/profile");
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
    }
  }
});
</script>
