<template>
  <div
    v-if="userpop === true"
    class="s-header-user-nav absolute right-0 top-16 bg-header-purple border-main-gray-light border text-main-gray-light w-40 divide-y divide-main-gray-light transition duration-500 ease-in-out"
  >
    <ul>
      <li>
        <a
          @click="onNavigate('/profile')"
          class="cursor-pointer block px-2 py-0.5 hover:bg-white transition duration-500 ease-in-out"
          >Личный профиль</a
        >
      </li>
      <li>
        <a
          data-toggle="modal"
          data-target="#popModal"
          class="cursor-pointer block px-2 py-0.5 open-popup hover:bg-white transition duration-500 ease-in-out"
          data-effect="mfp-zoom-in"
          >Изменить пароль</a
        >
      </li>
      <li>
        <a
          @click="logout"
          class="cursor-pointer block px-2 py-0.5 hover:bg-white transition duration-500 ease-in-out"
          >Выйти</a
        >
      </li>
    </ul>
  </div>
  <div
    class="modal fade"
    id="popModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="popModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <div
            class="s-popup mfp-with-anim mfp-hide max-w-2xl mx-auto bg-white px-8 py-12 relative"
            id="popup"
          >
            <div class="s-popup-inner">
              <button class="mfp-close" data-dismiss="modal" aria-label="Close">
                <i class="fas fa-times"></i>
              </button>
              <div class="border-b border-black">
                <h2 class="text-black text-2xl">Изменение пароля</h2>
              </div>
              <form action="main.php">
                <ul class="s-about-info text-black max-w-2xl pt-8">
                  <li class="flex mb-6">
                    <div class="font-bold w-2/5 md:w-3/6">Текущий пароль</div>
                    <div class="w-3/5 md:w-3/6">
                      <div class="input">
                        <input
                          type="password"
                          name="passwcur"
                          class="block border border-nav-blue rounded shadow-md1 outline-none text-main-gray-light px-4 h-8"
                          v-model="current_password"
                          @keypress="keysubmit($event)"
                        />
                      </div>
                    </div>
                  </li>
                  <li class="flex mb-6">
                    <div class="font-bold w-2/5 md:w-3/6">Новый пароль</div>
                    <div class="w-3/5 md:w-3/6">
                      <div class="input">
                        <input
                          type="password"
                          name="passwnew"
                          class="block border border-nav-blue rounded shadow-md1 outline-none text-main-gray-light px-4 h-8"
                          v-model="password"
                          @keypress="keysubmit($event)"
                        />
                      </div>
                    </div>
                  </li>
                  <li class="flex">
                    <div class="font-bold w-2/5 md:w-3/6">
                      Повторите новый пароль
                    </div>
                    <div class="w-3/5 md:w-3/6">
                      <div class="input">
                        <input
                          type="password"
                          name="passwrep"
                          class="block border border-nav-blue rounded shadow-md1 outline-none text-main-gray-light px-4 h-8"
                          v-model="password_confirmation"
                          @keypress="keysubmit($event)"
                        />
                      </div>
                    </div>
                  </li>
                </ul>
                <div
                  class="s-popup-buttons flex pt-8 justify-between max-w-sm mx-auto"
                >
                  <div>
                    <button
                      type="button"
                      @click="update"
                      @keypress="keysubmit($event)"
                      class="group text-lg relative flex justify-center px-4 border border-transparent text-sm font-medium rounded-md text-white bg-main-blue-medium font-bold transition duration-500 ease-in-out hover:bg-blue-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:bg-blue-400 h-8"
                    >
                      Сохранить
                    </button>
                  </div>
                  <div>
                    <button
                      type="button"
                      data-dismiss="modal"
                      aria-label="Close"
                      class="group text-lg relative flex justify-center px-4 border border-transparent text-sm font-medium rounded-md bg-white border border-main-gray-light font-bold text-main-gray transition duration-500 ease-in-out hover:bg-main-gray-light hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:bg-main-gray-light h-8 focus:text-white"
                    >
                      Отмена
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref } from "vue";
import axios from "axios";

export default defineComponent({
  name: "PopComponent",
  props: {
    userpop: Boolean
  },
  setup() {
    const current_password = ref<string>("");
    const password = ref<string>("");
    const password_confirmation = ref<string>("");

    return { current_password, password, password_confirmation };
  },
  methods: {
    onNavigate(url: string): void {
      this.$router.push(url);
    },
    logout(): void {
      localStorage.clear();
      document.location = <any>"/";
    },
    keysubmit(event: any): void {
      if (event.key == "Enter") {
        this.update();
      }
    },
    update(): void {
      const vm = this;
      const auth = localStorage.getItem("token");
      const body = {
        current_password: this.current_password,
        password: this.password,
        password_confirmation: this.password_confirmation
      };
      axios
        .post("/api/v1/users/password", body, {
          headers: {
            "Content-Type": "application/vnd.api+json",
            Accept: "application/vnd.api+json",
            Authorization: "Bearer " + auth
          }
        })
        .then(function (response: any) {
          alert("пароль изменен");
          vm.logout();
        })
        .catch(function (error: any) {
          alert("Ошибка проверки");
          console.log(error.response.data);
        });
    }
  }
});
</script>

<style scoped></style>
