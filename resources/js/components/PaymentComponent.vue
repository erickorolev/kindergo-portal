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
                ("0" + new Date(payment.pay_date).getDate()).substr(-2) +
                "." +
                ("0" + (new Date(payment.pay_date).getMonth() + 1)).substr(-2) +
                "." +
                new Date(payment.pay_date).getFullYear()
              }}
            </div>
          </li>
          <li class="block sm:flex mb-6 md:w-1/2 w-full">
            <div class="font-bold w-full sm:w-3/6 px-3">Сумма (руб)</div>
            <div class="w-full sm:w-3/6 font-sans px-3">
              {{ payment.amount }}
            </div>
          </li>
          <li class="block sm:flex mb-6 md:w-1/2 w-full">
            <div class="font-bold w-full sm:w-3/6 px-3">
              Подпись <br />сопровождающего
            </div>
            <div class="w-full sm:w-3/6 font-sans px-3">
              {{ payment.attendanta_signature }}
            </div>
          </li>
          <li class="block sm:flex mb-6 md:w-1/2 w-full">
            <div class="font-bold w-full sm:w-3/6 px-3">Статус</div>
            <div class="w-full sm:w-3/6 font-sans px-3">
              {{ payment.spstatus }}
            </div>
          </li>
          <li class="block sm:flex mb-6 md:w-1/2 w-full">
            <div class="font-bold w-full sm:w-3/6 px-3">
              Причина оспаривания
            </div>
            <div class="w-full sm:w-3/6 font-sans px-3">
              {{ payment.dispute_reason }}
            </div>
          </li>
        </ul>
        <div class="md:mt-10 mt-12">
          <a
            @click="onNavigate('/payments/edit/' + payment.id)"
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
import { Payment } from "../types/payments";

export default defineComponent({
  name: "PaymentComponent",
  components: {
    HeaderComponent
  },
  setup() {
    const payment = ref<Payment>({
      id: "",
      pay_date: "",
      pay_type: "",
      amount: 0,
      spstatus: "",
      attendanta_signature: "",
      dispute_reason: ""
    });
    return { payment };
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
        vm.payment.id = response.data.data.id;
        vm.payment.pay_date = response.data.data.attributes.pay_date;
        vm.payment.pay_type =
          response.data.data.attributes.pay_type.description;
        vm.payment.amount = response.data.data.attributes.amount.value;
        vm.payment.spstatus =
          response.data.data.attributes.spstatus.description;
        vm.payment.attendanta_signature =
          response.data.data.attributes.attendanta_signature.description;
        vm.payment.dispute_reason =
          response.data.data.attributes.dispute_reason;
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
