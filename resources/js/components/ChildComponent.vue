<template>
  <div class="s-page overflow-hidden">
    <header-component />
    <div class="s-about py-8">
      <div class="container mx-auto">
        <div class="border-b border-black">
          <h2 class="text-black text-2xl">Информация о ребенке</h2>
        </div>
        <div class="flex pt-8 justify-start flex-wrap md:flex-nowrap">
          <div class="w-full lg:w-1/2 md:w-4/5 order-2 md:order-1 pt-6 md:pt-0">
            <ul class="s-about-info text-black max-w-2xl pr-6">
              <li class="block sm:flex mb-6">
                <div class="font-bold w-2/5 md:w-3/6">Имя</div>
                <div class="w-3/5 md:w-3/6">
                  <div class="text flex items-center">
                    {{ child.firstname }}
                  </div>
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-2/5 md:w-3/6">Фамилия</div>
                <div class="w-3/5 md:w-3/6">{{ child.lastname }}</div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-2/5 md:w-3/6">Отчество</div>
                <div class="w-3/5 md:w-3/6">{{ child.middle_name }}</div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-2/5 md:w-3/6">Дата рождения</div>
                <div class="w-3/5 md:w-3/6">
                  {{
                    ("0" + new Date(child.birthday).getDate()).substr(-2) +
                    "." +
                    ("0" + (new Date(child.birthday).getMonth() + 1)).substr(
                      -2
                    ) +
                    "." +
                    new Date(child.birthday).getFullYear()
                  }}
                </div>
              </li>
              <li class="block sm:flex mb-6">
                <div class="font-bold w-2/5 md:w-3/6">Пол</div>
                <div class="w-3/5 md:w-3/6">{{ child.gender }}</div>
              </li>
            </ul>
          </div>
          <div class="w-full lg:w-1/2 md:w-1/5 order-1 md:order-2">
            <div class="s-about-avatar pr-4">
              <div class="font-bold pb-4 text-black">Фотография</div>
              <img
                v-if="child.media !== ''"
                :src="child.media"
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
import { Child } from "../types/children";

export default defineComponent({
  name: "ChildComponent",
  components: {
    HeaderComponent
  },
  setup() {
    const showParam = ref<boolean>(false);
    const child = ref<Child>({
      id: "",
      firstname: "",
      lastname: "",
      middle_name: "",
      birthday: "",
      gender: "",
      media: ""
    });
    return { showParam, child };
  },
  mounted() {
    const auth = localStorage.getItem("token");
    const vm = this;
    const currentUrl = this.$route.path;
    axios
      .get(`/api/v1${currentUrl}`, {
        headers: {
          "Content-Type": "application/vnd.api+json",
          Accept: "application/vnd.api+json",
          Authorization: "Bearer " + auth
        }
      })
      .then(function (response: any) {
        vm.child.id = response.data.data.id;
        vm.child.firstname = response.data.data.attributes.firstname;
        vm.child.lastname = response.data.data.attributes.lastname;
        vm.child.middle_name = response.data.data.attributes.middle_name;
        vm.child.birthday = response.data.data.attributes.birthday;
        vm.child.gender = response.data.data.attributes.gender.description;
        vm.child.media =
          response.data.data.attributes.media.length > 0
            ? response.data.data.attributes.media[0].url
            : "";
      })
      .catch(function (error) {
        console.log(error);
      });
  },
  methods: {}
});
</script>
