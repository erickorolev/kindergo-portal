<template>
    <div>
        <div class="s-page overflow-hidden">
            <header class="s-header bg-header-purple py-4">
                <div class="container mx-auto">
                    <div class="flex justify-between items-center relative">
                        <div class="flex justify-start items-center">
                            <div class="s-header-toggle w-5  block lg:hidden text-3xl md:mr-6 mr-4 cursor-pointer">
                                <i class="fas fa-bars"></i>
                                <i class="fas fa-times hidden"></i>
                            </div>
                            <div class="s-header-logo mr-6">
                                <a href="/">
                                    <img class="mx-auto w-auto" src="/assets/images/logo.jpg" alt="Kindergo Driveclub">
                                </a>
                            </div>
                            <ul class="s-header-list list-none m-0 border border-main-gray-light flex justify-start rounded-lg bg-white items-stretch hidden lg:flex">
                                <li class="lg:border-r border-main-gray-light active lg:rounded-l-lg"><a href="#" class="px-5 py-3.5 block lg:rounded-l-lg hover:bg-header-blue transition duration-500 ease-in-out">Поездки // trips</a></li>
                                <li class="lg:border-r border-main-gray-light"><a href="#" class="px-5 py-3.5 block hover:bg-header-blue transition duration-500 ease-in-out">Расписания // timetables</a></li>
                                <li class="lg:border-r border-main-gray-light"><a href="#" class="px-5 py-3.5 block hover:bg-header-blue transition duration-500 ease-in-out">Платежи // payments</a></li>
                                <li class="lg:border-r border-main-gray-light"><a href="#" class="px-5 py-3.5 block hover:bg-header-blue transition duration-500 ease-in-out">Дети // Children</a></li>
                                <li class="rounded-r-lg"><a href="#" class="px-5 py-3.5 block rounded-r-lg hover:bg-header-blue transition duration-500 ease-in-out">Сопровождающие // Attendants</a></li>
                            </ul>
                        </div>
                        <div class="flex">
                            <div class="s-header-user relative " id="usernav">
                                <a href="#"><img src="/assets/images/avatar.png" alt="img" class="block sm:w-user w-12 max-w-10" width="60"></a>
                                <div class="s-header-user-nav absolute right-0 top-16 bg-header-purple border-main-gray-light border text-main-gray-light w-40 divide-y divide-main-gray-light opacity-0 invisible transition duration-500 ease-in-out" >
                                    <ul>
                                        <li>
                                            <a href="#" class="block px-2 py-0.5 hover:bg-white transition duration-500 ease-in-out">Личный профиль</a>
                                        </li>
                                        <li><a href="#popup" class="block px-2 py-0.5 open-popup hover:bg-white transition duration-500 ease-in-out" data-effect="mfp-zoom-in">Изменить пароль</a></li>
                                        <li><a href="#" class="block px-2 py-0.5 hover:bg-white transition duration-500 ease-in-out">Выйти</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <div class="s-trips py-8">
                <div class="container mx-auto">
                    <div class="flex justify-between items-center s-trips-top">
                        <div>
                            <h2 class="text-black text-2xl">Ваши поездки</h2>
                        </div>
                    </div>
                    <div class="s-trips-table pt-8">
                        <div class="divide-y divide-black border-t border-black border-b">
                            <div>
                                <div class="s-trips-table-head flex-nowrap flex  font-bold py-1.5 ">
                                    <div class="px-3.5 w-72">Откуда</div>
                                    <div class="px-3.5 w-72">Куда</div>
                                    <div class="px-3.5 w-52">Дата отправления</div>
                                    <div class="px-3.5 w-52">Время отправления</div>
                                    <div class="pl-3.5 w-44">Статус</div>
                                </div>
                            </div>
                            <div class="hover:bg-header-blue transition duration-500 ease-in-out s-trops-table-linewrap">
                                <a href="#" class="s-trips-table-line flex-nowrap flex   py-3">
                                    <span class="px-3.5 w-72">г. Москва ул. Рябиновая, 45</span>
                                    <span class="px-3.5 w-72">г. Москва ул. Свободы, 45</span>
                                    <span class="px-3.5 w-52">17.07.2021</span>
                                    <span class="px-3.5 w-52">8:30</span>
                                    <span class="pl-3.5 w-44">Назначена</span>
                                </a>
                            </div>
                            <div class="hover:bg-header-blue transition duration-500 ease-in-out s-trops-table-linewrap">
                                <a href="#" class="s-trips-table-line flex-nowrap flex   py-3">
                                    <span class="px-3.5 w-72">г. Москва ул. Маяковского, 38</span>
                                    <span class="px-3.5 w-72">г. Москва ул. Лесотехникума, 45</span>
                                    <span class="px-3.5 w-52">19.07.2021</span>
                                    <span class="px-3.5 w-52">8:30</span>
                                    <span class="pl-3.5 w-44">Выполнена</span>
                                </a>
                            </div>
                            <div class="hover:bg-header-blue transition duration-500 ease-in-out s-trops-table-linewrap">
                                <a href="#" class="s-trips-table-line flex-nowrap flex   py-3">
                                    <span class="px-3.5 w-72">г. Москва ул. Маяковского, 113</span>
                                    <span class="px-3.5 w-72">г. Москва ул. Лесотехникума, 128</span>
                                    <span class="px-3.5 w-52">21.07.2021</span>
                                    <span class="px-3.5 w-52">8:30</span>
                                    <span class="pl-3.5 w-44">Выполнена</span>
                                </a>
                            </div>
                            <div class="hover:bg-header-blue transition duration-500 ease-in-out s-trops-table-linewrap">
                                <a href="#" class="s-trips-table-line flex-nowrap flex   py-3">
                                    <span class="px-3.5 w-72">г. Москва ул. Рябиновая, 45</span>
                                    <span class="px-3.5 w-72">г. Москва ул. Свободы, 45</span>
                                    <span class="px-3.5 w-52">17.07.2021</span>
                                    <span class="px-3.5 w-52">8:30</span>
                                    <span class="pl-3.5 w-44">Назначена</span>
                                </a>
                            </div>
                            <div class="hover:bg-header-blue transition duration-500 ease-in-out s-trops-table-linewrap">
                                <a href="#" class="s-trips-table-line flex-nowrap flex   py-3">
                                    <span class="px-3.5 w-72">г. Москва ул. Маяковского, 38</span>
                                    <span class="px-3.5 w-72">г. Москва ул. Лесотехникума, 45</span>
                                    <span class="px-3.5 w-52">19.07.2021</span>
                                    <span class="px-3.5 w-52">8:30</span>
                                    <span class="pl-3.5 w-44">Выполнена</span>
                                </a>
                            </div>
                            <div class="hover:bg-header-blue transition duration-500 ease-in-out s-trops-table-linewrap">
                                <a href="#" class="s-trips-table-line flex-nowrap flex   py-3">
                                    <span class="px-3.5 w-72">г. Москва ул. Маяковского, 113</span>
                                    <span class="px-3.5 w-72">г. Москва ул. Лесотехникума, 128</span>
                                    <span class="px-3.5 w-52">21.07.2021</span>
                                    <span class="px-3.5 w-52">8:30</span>
                                    <span class="pl-3.5 w-44">Выполнена</span>
                                </a>
                            </div>
                            <div class="hover:bg-header-blue transition duration-500 ease-in-out s-trops-table-linewrap">
                                <a href="#" class="s-trips-table-line flex-nowrap flex   py-3">
                                    <span class="px-3.5 w-72">г. Москва ул. Рябиновая, 45</span>
                                    <span class="px-3.5 w-72">г. Москва ул. Свободы, 45</span>
                                    <span class="px-3.5 w-52">17.07.2021</span>
                                    <span class="px-3.5 w-52">8:30</span>
                                    <span class="pl-3.5 w-44">Назначена</span>
                                </a>
                            </div>
                            <div class="hover:bg-header-blue transition duration-500 ease-in-out s-trops-table-linewrap">
                                <a href="#" class="s-trips-table-line flex-nowrap flex   py-3">
                                    <span class="px-3.5 w-72">г. Москва ул. Маяковского, 38</span>
                                    <span class="px-3.5 w-72">г. Москва ул. Лесотехникума, 45</span>
                                    <span class="px-3.5 w-52">19.07.2021</span>
                                    <span class="px-3.5 w-52">8:30</span>
                                    <span class="pl-3.5 w-44">Выполнена</span>
                                </a>
                            </div>
                            <div class="hover:bg-header-blue transition duration-500 ease-in-out s-trops-table-linewrap">
                                <a href="#" class="s-trips-table-line flex-nowrap flex   py-3">
                                    <span class="px-3.5 w-72">г. Москва ул. Маяковского, 113</span>
                                    <span class="px-3.5 w-72">г. Москва ул. Лесотехникума, 128</span>
                                    <span class="px-3.5 w-52">21.07.2021</span>
                                    <span class="px-3.5 w-52">8:30</span>
                                    <span class="pl-3.5 w-44">Выполнена</span>
                                </a>
                            </div>
                            <div class="hover:bg-header-blue transition duration-500 ease-in-out s-trops-table-linewrap">
                                <a href="#" class="s-trips-table-line flex-nowrap flex   py-3">
                                    <span class="px-3.5 w-72">г. Москва ул. Маяковского, 38</span>
                                    <span class="px-3.5 w-72">г. Москва ул. Лесотехникума, 45</span>
                                    <span class="px-3.5 w-52">19.07.2021</span>
                                    <span class="px-3.5 w-52">8:30</span>
                                    <span class="pl-3.5 w-44">Выполнена</span>
                                </a>
                            </div>

                        </div>
                    </div>
                    <div class="flex justify-end items-center pt-12">
                        <div class="s-trips-nav flex justify-start text-center text-base items-stretch">
                            <a href="#" class="arrow-left block border-nav-gray-light border flex-initial rounded-l-md hover:border-main-gray-light transition duration-500 ease-in-out"><i class="fa fa-angle-left text-main-gray "></i></a>
                            <ul class="flex justify-start items-stretch">
                                <li class="active"><a href="#" class="bg-nav-gray-light block">1</a></li>
                            </ul>
                            <a href="#" class="arrow-right blockborder-nav-gray-light border rounded-r-md hover:border-main-gray-light transition duration-500 ease-in-out"><i class="fa fa-angle-right text-main-gray"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue'

export default defineComponent({
    name: "App"
})
</script>

<style scoped>

</style>
