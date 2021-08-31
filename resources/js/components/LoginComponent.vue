<template>
  <div
    class="min-h-screen flex items-center justify-center bg-white py-12 px-4 sm:px-6 lg:px-8 s-login"
  >
    <div class="max-w-md w-full space-y-4">
      <div>
        <img
          class="mx-auto w-auto"
          src="../../img/logo.jpg"
          alt="Kindergo Driveclub"
        />
      </div>
      <div
        class="s-login-form border border-main-gray max-w-xs mx-auto p-4 pb-10"
      >
        <p class="text-main-gray-light text-sm tracking-tight mb-0.5">
          Вход в личный кабинет
        </p>
        <div class="line border-b-2 border-main-blue-light"></div>
        <form ref="form">
          <div class="mt-3 d-block">
            <label for="email-address" class="text-main-gray-light text-sm"
              >Email:</label
            >
            <input
              id="email-address"
              name="email"
              type="email"
              autocomplete="email"
              required
              class="appearance-none rounded-none relative block w-full px-3 py-2 border border-main-gray placeholder-gray-500 text-sm text-main-gray-light focus:outline-none focus:border-main-blue-light focus:z-10 transition duration-500 ease-in-out"
              placeholder=""
              v-model="email"
              @keypress="keysubmit($event)"
            />
          </div>
          <div class="mt-3">
            <label for="password" class="text-main-gray-light text-sm"
              >Пароль:</label
            >
            <input
              id="password"
              name="password"
              type="password"
              autocomplete="current-password"
              required
              class="appearance-none rounded-none relative block w-full px-3 py-2 border border-main-gray placeholder-gray-500 text-main-gray-light focus:outline-none focus:border-main-blue-light focus:z-10 text-sm transition duration-500 ease-in-out"
              placeholder=""
              v-model="password"
              @keypress="keysubmit($event)"
            />
          </div>
          <div class="mt-3 ml-2">
            <button
              type="button"
              class="group text-lg relative flex justify-center px-4 border border-transparent text-sm font-medium rounded-md text-white bg-main-blue-medium font-bold transition duration-500 ease-in-out hover:bg-blue-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:bg-blue-400"
              @click="submit"
              @keypress="keysubmit($event)"
            >
              Войти
            </button>
          </div>
        </form>
        <div class="mt-3">
          <div class="text-sm mb-1">
            <a
              data-toggle="modal"
              data-target="#popModal"
              class="cursor-pointer font-normal transition duration-500 ease-in-out underline text-main-purple-medium hover:text-indigo-500 text-sm open-popup"
              data-effect="mfp-zoom-in"
            >
              Забыли пароль?
            </a>
          </div>
          <div class="line border-b-2 border-main-blue-light"></div>
        </div>
      </div>
    </div>
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
              <button
                class="mfp-close"
                title="Close (Esc)"
                type="button"
                data-dismiss="modal"
                aria-label="Close"
              >
                <i class="fas fa-times"></i>
              </button>
              <div class="border-b border-black">
                <h2 class="text-black text-2xl">Напомнить пароль</h2>
              </div>
              <form action="main.php">
                <ul class="s-about-info text-black max-w-2xl pt-8">
                  <li class="flex mb-6">
                    <div class="font-bold w-2/5 md:w-3/6">Ваша почта</div>
                    <div class="w-3/5 md:w-3/6">
                      <div class="input">
                        <input
                          type="text"
                          name="email"
                          class="block border border-nav-blue rounded shadow-md1 outline-none text-main-gray-light px-4 h-8"
                          value=""
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
                      type="submit"
                      class="group text-lg relative flex justify-center px-4 border border-transparent text-sm font-medium rounded-md text-white bg-main-blue-medium font-bold transition duration-500 ease-in-out hover:bg-blue-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:bg-blue-400 h-8"
                    >
                      Отправить
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
  name: "LoginComponent",
  setup() {
    const email = ref("");
    const password = ref<number | string>("");

    return { email, password };
  },
  mounted() {},
  methods: {
    submit(): void {
      const vm = this;
      axios
        .post(
          "/api/v1/login",
          {
            email: this.email,
            password: this.password
          },
          {
            headers: {
              "Content-Type": "application/vnd.api+json",
              Accept: "application/vnd.api+json"
            }
          }
        )
        .then(function (response: any) {
          localStorage.setItem("token", response.data.token);
          vm.$router.push("trips");
        })
        .catch(function (error) {
          alert("учетные данные неверны");
          console.log(error);
        });
    },
    keysubmit(event: any): void {
      if (event.key == "Enter") {
        this.submit();
      }
    }
  }
});
</script>
