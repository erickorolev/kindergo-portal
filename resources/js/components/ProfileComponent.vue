<template>
  <div class="s-page overflow-hidden">
    <header-component />
    <div class="s-about py-8 pb-20">
      <div class="container mx-auto">
        <div class="border-b border-black">
          <h2 class="text-black text-2xl">Информация вашего профиля</h2>
        </div>
        <div class="flex pt-8 justify-start flex-wrap md:flex-nowrap">
          <div class="w-full lg:w-3/5 md:w-4/5 order-2 md:order-1 pt-6 md:pt-0">
            <ul class="s-about-info text-black max-w-2xl md:pr-20 text-base">
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">Имя</div>
                <div class="w-full sm:w-3/5 md:w-3/6">
                  <div class="text flex items-center font-sans">
                    {{ profile.firstname }}
                  </div>
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">Фамилия</div>
                <div class="w-full sm:w-3/5 md:w-3/6 font-sans">
                  {{ profile.lastname }}
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">Отчество</div>
                <div class="w-full sm:w-3/5 md:w-3/6 font-sans">
                  {{ profile.middle_name }}
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">E-mail</div>
                <div class="w-full sm:w-3/5 md:w-3/6 font-sans">
                  {{ profile.email }}
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">Телефон</div>
                <div class="w-full sm:w-3/5 md:w-3/6 font-sans">
                  {{ profile.phone }}
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">Другой тел</div>
                <div class="w-full sm:w-3/5 md:w-3/6 font-sans">
                  {{ profile.otherphone }}
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">Пол</div>
                <div class="w-full sm:w-3/5 md:w-3/6 font-sans">
                  {{ profile.gender }}
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">Категория</div>
                <div class="w-full sm:w-3/5 md:w-3/6 font-sans">
                  {{ profile.attendant_category }}
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">Статус</div>
                <div class="w-full sm:w-3/5 md:w-3/6 font-sans">
                  {{ profile.attendant_status }}
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">
                  Дата трудоустройства
                </div>
                <div class="w-full sm:w-3/5 md:w-3/6 font-sans">
                  {{
                    ("0" + new Date(profile.attendant_hired).getDate()).substr(
                      -2
                    ) +
                    "." +
                    (
                      "0" +
                      (new Date(profile.attendant_hired).getMonth() + 1)
                    ).substr(-2) +
                    "." +
                    new Date(profile.attendant_hired).getFullYear()
                  }}
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">
                  День рождения
                </div>
                <div class="w-full sm:w-3/5 md:w-3/6 font-sans">
                  {{
                    ("0" + new Date(profile.birthday).getDate()).substr(-2) +
                    "." +
                    ("0" + (new Date(profile.birthday).getMonth() + 1)).substr(
                      -2
                    ) +
                    "." +
                    new Date(profile.birthday).getFullYear()
                  }}
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="italic text-black text-lg">Адрес регистрации</div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">Индекс</div>
                <div class="w-full sm:w-3/5 md:w-3/6 font-sans">
                  {{ profile.mailingzip }}
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">Страна</div>
                <div class="w-full sm:w-3/5 md:w-3/6 font-sans">
                  {{ profile.mailingcountry }}
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">Область</div>
                <div class="w-full sm:w-3/5 md:w-3/6 font-sans">
                  {{ profile.mailingstate }}
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">Город</div>
                <div class="w-full sm:w-3/5 md:w-3/6 font-sans">
                  {{ profile.mailingcity }}
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">
                  Улица, дом, квартира
                </div>
                <div class="w-full sm:w-3/5 md:w-3/6 font-sans">
                  {{ profile.mailingstreet }}
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="italic text-black text-lg">Адрес проживания</div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">Индекс</div>
                <div class="w-full sm:w-3/5 md:w-3/6 font-sans">
                  {{ profile.otherzip }}
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">Страна</div>
                <div class="w-full sm:w-3/5 md:w-3/6 font-sans">
                  {{ profile.othercountry }}
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">Область</div>
                <div class="w-full sm:w-3/5 md:w-3/6 font-sans">
                  {{ profile.otherstate }}
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">Город</div>
                <div class="w-full sm:w-3/5 md:w-3/6 font-sans">
                  {{ profile.othercity }}
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">
                  Улица, дом, квартира
                </div>
                <div class="w-full sm:w-3/5 md:w-3/6 font-sans">
                  {{ profile.otherstreet }}
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">
                  Станция метро
                </div>
                <div class="w-full sm:w-3/5 md:w-3/6 font-sans">
                  {{ profile.metro_station }}
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">
                  Марка автомобиля
                </div>
                <div class="w-full sm:w-3/5 md:w-3/6 font-sans">
                  {{ profile.car_model }}
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">
                  Год автомобиля
                </div>
                <div class="w-full sm:w-3/5 md:w-3/6 font-sans">
                  {{ profile.car_year }}
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">
                  Цвет автомобиля
                </div>
                <div class="w-full sm:w-3/5 md:w-3/6 font-sans">
                  {{ profile.car_color }}
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">
                  Тел куратора
                </div>
                <div class="w-full sm:w-3/5 md:w-3/6 font-sans"></div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">
                  Платежные данные
                </div>
                <div class="w-full sm:w-3/5 md:w-3/6 font-sans">
                  {{ profile.payment_data }}
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-full sm:w-2/5 md:w-3/6">Анкета</div>
                <div class="w-full sm:w-3/5 md:w-3/6 font-sans">
                  <p>
                    {{ profile.resume }}
                  </p>
                </div>
              </li>
            </ul>
            <div class="md:mt-10 mt-12">
              <a
                @click="onNavigate('/profile/edit/' + profile.id)"
                class="cursor-pointer s-about-btn group relative inline-flex justify-center px-8 py-3 border border-transparent text-sm font-medium rounded-md text-white bg-btn-bg font-bold transition duration-500 ease-in-out hover:bg-blue-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:bg-blue-400 text-sm border border-btn-border"
              >
                Изменить
              </a>
            </div>
          </div>
          <div class="w-full lg:w-2/5 md:w-1/5 order-1 md:order-2">
            <div class="s-about-avatar pr-4">
              <div class="font-bold pb-4 text-black">Фотография</div>
              <img
                :src="profile.media"
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
import { Profile } from "../types/profile";
import { base_url } from "../data";

export default defineComponent({
  name: "ProfileComponent",
  components: {
    HeaderComponent
  },
  setup() {
    const profile = ref<Profile>({
      id: "",
      firstname: "",
      lastname: "",
      middle_name: "",
      email: "",
      phone: "",
      otherphone: "",
      gender: "",
      attendant_category: "",
      attendant_status: "",
      attendant_hired: "",
      birthday: "",
      mailingzip: 0,
      mailingcountry: "",
      mailingstate: "",
      mailingcity: "",
      mailingstreet: "",
      otherzip: 0,
      othercountry: "",
      otherstate: "",
      othercity: "",
      otherstreet: "",
      metro_station: "",
      car_model: "",
      car_year: 0,
      car_color: "",
      resume: "",
      payment_data: "",
      media: ""
    });
    return { profile, base_url };
  },
  mounted() {
    this.getData("/api/v1/users/me");
  },
  methods: {
    onNavigate(url: string): void {
      this.$router.push(url);
    },
    getData(url: string) {
      const auth = localStorage.getItem("token");
      const vm = this;

      axios
        .get(url, {
          headers: {
            "Content-Type": "application/vnd.api+json",
            Accept: "application/vnd.api+json",
            Authorization: "Bearer " + auth
          }
        })
        .then(function (response: any) {
          vm.profile.id = response.data.data.id;
          vm.profile.firstname = response.data.data.attributes.firstname;
          vm.profile.lastname = response.data.data.attributes.lastname;
          vm.profile.middle_name = response.data.data.attributes.middle_name;
          vm.profile.email = response.data.data.attributes.email;
          vm.profile.phone = response.data.data.attributes.phone;
          vm.profile.otherphone = response.data.data.attributes.otherphone;
          vm.profile.gender = response.data.data.attributes.gender.description;
          vm.profile.attendant_category =
            response.data.data.attributes.attendant_category.description;
          vm.profile.attendant_status =
            response.data.data.attributes.attendant_status.description;
          vm.profile.attendant_hired =
            response.data.data.attributes.attendant_hired;
          vm.profile.birthday = response.data.data.attributes.birthday;
          vm.profile.mailingzip = response.data.data.attributes.mailingzip;
          vm.profile.mailingstate = response.data.data.attributes.mailingstate;
          vm.profile.mailingcountry =
            response.data.data.attributes.mailingcountry;
          vm.profile.mailingcity = response.data.data.attributes.mailingcity;
          vm.profile.mailingstreet =
            response.data.data.attributes.mailingstreet;
          vm.profile.otherzip = response.data.data.attributes.otherzip;
          vm.profile.otherstate = response.data.data.attributes.otherstate;
          vm.profile.othercountry = response.data.data.attributes.othercountry;
          vm.profile.othercity = response.data.data.attributes.othercity;
          vm.profile.otherstreet = response.data.data.attributes.otherstreet;
          vm.profile.metro_station =
            response.data.data.attributes.metro_station;
          vm.profile.car_model = response.data.data.attributes.car_model;
          vm.profile.car_year = response.data.data.attributes.car_year;
          vm.profile.car_color = response.data.data.attributes.car_color;
          vm.profile.resume = response.data.data.attributes.resume;
          vm.profile.payment_data = response.data.data.attributes.payment_data;
          vm.profile.media =
            response.data.data.attributes.media.length > 0
              ? response.data.data.attributes.media[0].url
              : "";
        })
        .catch(function (error) {
          console.log(error);
        });
    }
  }
});
</script>
