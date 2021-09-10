<template>
  <div class="s-page overflow-hidden">
    <header-component />
    <div class="s-trips py-8">
      <div class="container mx-auto">
        <div class="flex justify-between items-center s-trips-top">
          <div>
            <h2 class="text-black text-2xl">Ваши платежи</h2>
          </div>
        </div>
        <div class="s-trips-table pt-8">
          <div
            class="divide-y divide-black border-t border-black border-b lg:w-full w-auto"
          >
            <div>
              <div
                class="s-trips-table-head flex-nowrap flex font-bold py-1.5 w-full"
              >
                <div class="px-3.5 w-60">Дата</div>
                <div class="px-3.5 w-60">Сумма (руб)</div>
                <div class="pl-3.5 w-44">Статус</div>
              </div>
            </div>
            <div
              v-for="(item, key) in payments"
              :key="key"
              class="hover:bg-header-blue transition duration-500 ease-in-out s-trops-table-linewrap"
            >
              <a
                @click="onNavigate('/payments/' + item.id)"
                class="cursor-pointer s-trips-table-line flex-nowrap flex py-3 w-full"
              >
                <span class="px-3.5 w-60">{{
                  ("0" + new Date(item.pay_date).getDate()).substr(-2) +
                  "." +
                  ("0" + (new Date(item.pay_date).getMonth() + 1)).substr(-2) +
                  "." +
                  new Date(item.pay_date).getFullYear()
                }}</span>
                <span class="px-3.5 w-60">{{ formatPrice(item.amount) }}</span>
                <span class="pl-3.5 w-44">{{ item.spstatus }}</span>
              </a>
            </div>
          </div>
        </div>
        <div class="flex justify-end items-center pt-12">
          <div
            class="s-trips-nav flex justify-start text-center text-base items-stretch"
          >
            <a
              @click="getData(links.first)"
              class="arrow-left block border-nav-gray-light border flex-initial rounded-l-md hover:border-main-gray-light transition duration-500 ease-in-out"
              ><i class="fa fa-angle-left text-main-gray"></i
            ></a>
            <a
              v-if="links.prev"
              @click="getData(links.prev)"
              class="arrow-left block border-nav-gray-light border flex-initial rounded-l-md hover:border-main-gray-light transition duration-500 ease-in-out"
              ><i class="fa fa-angle-left text-main-gray"></i
            ></a>
            <ul class="flex justify-start items-stretch">
              <li class="active">
                <a
                  @click="getData(links.self)"
                  class="bg-nav-gray-light block"
                  >{{ current_page }}</a
                >
              </li>
            </ul>
            <a
              v-if="links.next"
              @click="getData(links.next)"
              class="arrow-right blockborder-nav-gray-light border rounded-r-md hover:border-main-gray-light transition duration-500 ease-in-out"
              ><i class="fa fa-angle-right text-main-gray"></i
            ></a>
            <a
              @click="getData(links.last)"
              class="arrow-right blockborder-nav-gray-light border rounded-r-md hover:border-main-gray-light transition duration-500 ease-in-out"
              ><i class="fa fa-angle-right text-main-gray"></i
            ></a>
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
import { Payments } from "../types/payments";

export default defineComponent({
  name: "PaymentsComponent",
  components: {
    HeaderComponent
  },
  setup() {
    const payments = ref<Payments[]>([]);
    const links = ref<object>({});
    const current_page = ref<number>(0);
    return { payments, links, current_page };
  },
  mounted() {
    this.getData("/api/v1/payments");
  },
  methods: {
    onNavigate(url: string): void {
      this.$router.push(url);
    },
    getData(url: string) {
      const auth = localStorage.getItem("token");
      const vm = this;
      vm.payments = [];
      axios
        .get(url, {
          headers: {
            "Content-Type": "application/vnd.api+json",
            Accept: "application/vnd.api+json",
            Authorization: "Bearer " + auth
          }
        })
        .then(function (response: any) {
          response.data.data.forEach((item: any) => {
            const itemData = {
              id: item.id,
              pay_date: item.attributes.pay_date,
              amount: item.attributes.amount.value,
              spstatus: item.attributes.spstatus.description
            };
            vm.payments.push(itemData);
          });
          vm.links = Object.assign({}, response.data.links);
          vm.current_page = response.data.meta.pagination.current_page;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    formatPrice(value:number): string {
      let val = (value/1).toFixed(2).replace('.', ',')
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
    }
  }
});
</script>

<style scoped lang="scss">
.w-60 {
  @media (max-width: 767px) {
    width: 7rem;
  }
}
</style>
