<template>
  <div class="s-page overflow-hidden">
    <header-component />
    <div class="s-about py-8 pb-16">
      <div class="container mx-auto">
        <div class="border-b border-black pt-4">
          <h2 class="text-black text-2xl">Информация о платеже</h2>
        </div>
        <ul class="s-about-info text-black pt-8 flex flex-wrap -mx-3">
          <li class="block sm:flex mb-6 md:w-1/2 w-full">
            <div class="font-bold w-full sm:w-3/6 px-3">Дата</div>
            <div class="w-full sm:w-3/6 font-sans px-3">
              {{
                ("0" + new Date(pay_date).getDate()).substr(-2) +
                "." +
                ("0" + (new Date(pay_date).getMonth() + 1)).substr(-2) +
                "." +
                new Date(pay_date).getFullYear()
              }}
            </div>
          </li>
          <li class="block sm:flex mb-6 md:w-1/2 w-full">
            <div class="font-bold w-full sm:w-3/6 px-3">Сумма (руб)</div>
            <div class="w-full sm:w-3/6 font-sans px-3">{{ amount }}</div>
          </li>
          <li class="block sm:flex mb-6 md:w-1/2 w-full">
            <div class="font-bold w-full sm:w-3/6 px-3">
              Подпись <br />сопровождающего
            </div>
            <div class="w-full sm:w-3/6 font-sans px-3 relative">
              <span class="cursor-pointer" @click="showAttendantSignature">
                {{attendanta_signature_value}}
                <i class="fas fa-angle-down ml-2"></i>
              </span>
              <ul
                v-if="showAttendant"
                class="s-header-list list-none m-0 border border-main-gray-light flex justify-start rounded-lg bg-white items-stretch flex active"
              >
                <li class="border-r border-main-gray-light rounded-l" @click="attendantSignature('Waiting')">
                  Wating
                </li>
                <li class="border-r border-main-gray-light" @click="attendantSignature('Signed by')">
                  Signed by
                </li>
                <li class="border-r border-main-gray-light" @click="attendantSignature('Disputed')">
                  Disputed
                </li>
              </ul>
            </div>
          </li>
          <li class="block sm:flex mb-6 md:w-1/2 w-full">
            <div class="font-bold w-full sm:w-3/6 px-3">Статус</div>
            <div class="w-full sm:w-3/6 font-sans px-3">{{ spstatus }}</div>
          </li>
          <li class="block sm:flex mb-6 md:w-1/2 w-full">
            <div class="font-bold w-full sm:w-3/6 px-3">
              Причина оспаривания
            </div>
            <div class="w-full sm:w-3/6 font-sans px-3">
              <div class="input inline-flex w-full">
                <textarea
                  name="profiledata"
                  cols="30"
                  rows="10"
                  class="block w-full border-0 outline-none h-40 font-sans border border-main-gray p-2.5"
                  v-model="dispute_reason"
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
              @click="onNavigate('/payments/' + id)"
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

import { base_url } from "../data";

export default defineComponent({
  name: "PaymentEditComponent",
  components: {
    HeaderComponent
  },
  setup() {
    const showAttendant = ref<Boolean>(false);
    const id = ref<String>("");
    const pay_date = ref<String>("");
    const pay_type_value = ref<String>("");
    const amount = ref<String>("");
    const attendanta_signature = ref<String>("");
    const attendanta_signature_value = ref<String>("");
    const dispute_reason = ref<String>("");
    const spstatus = ref<String>("");
    const spstatus_value = ref<String>("");
    return {
      showAttendant,
      id,
      pay_date,
      pay_type_value,
      amount,
      attendanta_signature,
      attendanta_signature_value,
      dispute_reason,
      spstatus,
      spstatus_value
    };
  },
  mounted() {
    const auth = localStorage.getItem("token");
    const vm = this;
    const currentUrl = this.$route.path;
    this.id = currentUrl[currentUrl.length - 1];
    axios
      .get(`/api/v1/payments/${this.id}`, {
        headers: {
          "Content-Type": "application/vnd.api+json",
          Accept: "application/vnd.api+json",
          Authorization: "Bearer " + auth
        }
      })
      .then(function (response: any) {
        vm.id = response.data.data.id;
        vm.pay_date = response.data.data.attributes.pay_date;
        vm.pay_type_value = response.data.data.attributes.pay_type.value;
        vm.amount = response.data.data.attributes.amount.value;
        vm.spstatus = response.data.data.attributes.spstatus.description;
        vm.spstatus_value = response.data.data.attributes.spstatus.value;
        vm.attendanta_signature =
          response.data.data.attributes.attendanta_signature.description;
        vm.attendanta_signature_value =
          response.data.data.attributes.attendanta_signature.value;
        vm.dispute_reason = response.data.data.attributes.dispute_reason;
      })
      .catch(function (error) {
        console.log(error);
      });
  },
  methods: {
    update(): void {
      const vm = this;
      const auth = localStorage.getItem("token");
      const body = {
        data: {
          type: "payments",
          id: this.id,
          attributes: {
            pay_date: this.pay_date.substr(0, 10),
            amount: this.amount,
            pay_type: this.pay_type_value,
            attendanta_signature: this.attendanta_signature_value,
            dispute_reason: this.dispute_reason,
            spstatus: this.spstatus_value
          }
        }
      };
      axios
        .patch("/api/v1/payments/" + this.id, body, {
          headers: {
            "Content-Type": "application/vnd.api+json",
            Accept: "application/vnd.api+json",
            Authorization: "Bearer " + auth
          }
        })
        .then(function (response: any) {
          vm.$router.push(`/payments/${vm.id}`);
        })
        .catch(function (error) {
          console.log(error.response.data);
          vm.$router.push(`/payments/${vm.id}`);
        });
    },
    onNavigate(url: string): void {
      this.$router.push(url);
    },
    showAttendantSignature() {
      this.showAttendant = !this.showAttendant;
    },
    attendantSignature(value: string): void {
      this.attendanta_signature_value = value;
      this.showAttendant = false;
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
