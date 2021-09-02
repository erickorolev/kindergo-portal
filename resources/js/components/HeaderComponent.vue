<template>
  <div class="s-header bg-header-purple py-4">
    <div class="container mx-auto">
      <div class="flex justify-between items-center relative">
        <div class="flex justify-start items-center">
          <div
            class="s-header-toggle w-5 block lg:hidden text-3xl md:mr-6 mr-4 cursor-pointer"
          >
            <i v-if="!showMenu" class="fas fa-bars" @click="toggleMenu"></i>
            <i v-if="showMenu" class="fas fa-times" @click="toggleMenu"></i>
          </div>
          <div class="s-header-logo mr-6">
            <a class="cursor-pointer" @click="onNavigate('/')">
              <img
                class="mx-auto w-auto position-sticky"
                src="../../img/logo.jpg"
                alt="Kindergo Driveclub"
              />
            </a>
          </div>
          <ul
            v-if="showMenu"
            class="s-header-list list-none m-0 border border-main-gray-light flex justify-start rounded-lg bg-white items-stretch lg:hidden active"
          >
            <li
              class="lg:border-r border-main-gray-light lg:rounded-l-lg"
              :class="currentUrl.indexOf('trips') > -1 ? 'active' : ''"
            >
              <a
                @click="onNavigate('/trips')"
                class="cursor-pointer px-5 py-3.5 block lg:rounded-l-lg hover:bg-header-blue transition duration-500 ease-in-out"
                >Поездки</a
              >
            </li>
            <li
              class="lg:border-r border-main-gray-light"
              :class="currentUrl.indexOf('payments') > -1 ? 'active' : ''"
            >
              <a
                @click="onNavigate('/payments')"
                class="cursor-pointer px-5 py-3.5 block rounded-r-lg hover:bg-header-blue transition duration-500 ease-in-out"
                >Платежи</a
              >
            </li>
          </ul>
          <ul
            class="s-header-list list-none m-0 border border-main-gray-light flex justify-start rounded-lg bg-white items-stretch hidden lg:flex"
          >
            <li
              class="lg:border-r border-main-gray-light lg:rounded-l-lg"
              :class="currentUrl.indexOf('trips') > -1 ? 'active' : ''"
            >
              <a
                @click="onNavigate('/trips')"
                class="cursor-pointer px-5 py-3.5 block lg:rounded-l-lg hover:bg-header-blue transition duration-500 ease-in-out"
                >Поездки</a
              >
            </li>
            <li
              class="lg:border-r border-main-gray-light"
              :class="currentUrl.indexOf('payments') > -1 ? 'active' : ''"
            >
              <a
                @click="onNavigate('/payments')"
                class="cursor-pointer px-5 py-3.5 block rounded-r-lg hover:bg-header-blue transition duration-500 ease-in-out"
                >Платежи</a
              >
            </li>
          </ul>
        </div>
        <div class="flex">
          <div class="s-header-user relative" id="usernav">
            <img
              src="../../img/avatar.png"
              alt="img"
              class="block sm:w-user w-12 max-w-10"
              width="60"
              @click="openpop"
            />
            <pop-component :userpop="userpop" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref } from "vue";
import PopComponent from "./PopComponent.vue";

export default defineComponent({
  name: "HeaderComponent",
  data() {
    return {
      userpop: false,
      showMenu: false,
      currentUrl: this.$route.path
    };
  },
  components: {
    PopComponent
  },
  mounted() {},
  methods: {
    openpop(): void {
      this.userpop = !this.userpop;
      this.showMenu = false;
    },
    onNavigate(url: string): void {
      this.$router.push(url);
    },
    toggleMenu(): void {
      this.showMenu = !this.showMenu;
      this.userpop = false;
    }
  }
});
</script>
