<template>
    <div class="s-popup  mfp-with-anim mfp-hide max-w-2xl mx-auto bg-white px-8 py-12 relative" id="popup">
        <div class="s-popup-inner">
            <button class="mfp-close" title="Close (Esc)" type="button"><i class="fas fa-times"></i></button>
            <div class="border-b border-black">
                <h2 class="text-black text-2xl">Изменение пароля</h2>
            </div>
            <form action="main.php">
                <ul class="s-about-info text-black max-w-2xl pt-8">
                    <li class="flex mb-6">
                        <div class="font-bold w-2/5 md:w-3/6">Текущий пароль</div>
                        <div class="w-3/5 md:w-3/6">
                            <div class="input">
                                <input type="password" name="passwcur" class="block border border-nav-blue rounded shadow-md1 outline-none text-main-gray-light px-4 h-8" value="ул. Рябиновая, 45">
                            </div>
                        </div>
                    </li>
                    <li class="flex mb-6">
                        <div class="font-bold w-2/5 md:w-3/6">Новый пароль</div>
                        <div class="w-3/5 md:w-3/6">
                            <div class="input">
                                <input type="password" name="passwnew" class="block border border-nav-blue rounded shadow-md1 outline-none text-main-gray-light px-4 h-8" >
                            </div>
                        </div>
                    </li>
                    <li class="flex">
                        <div class="font-bold w-2/5 md:w-3/6">Повторите новый пароль</div>
                        <div class="w-3/5 md:w-3/6">
                            <div class="input">
                                <input type="password" name="passwrep" class="block border border-nav-blue rounded shadow-md1 outline-none text-main-gray-light px-4 h-8" >
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="s-popup-buttons flex pt-8 justify-between max-w-sm mx-auto">
                    <div>
                        <button type="submit" class="group text-lg relative flex justify-center  px-4 border border-transparent text-sm font-medium rounded-md text-white bg-main-blue-medium font-bold transition duration-500 ease-in-out hover:bg-blue-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:bg-blue-400  h-8">
                            Сохранить
                        </button>
                    </div>
                    <div>
                        <button type="submit" class="group text-lg relative flex justify-center  px-4 border border-transparent text-sm font-medium rounded-md bg-white border border-main-gray-light font-bold text-main-gray transition duration-500 ease-in-out hover:bg-main-gray-light hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:bg-main-gray-light h-8 focus:text-white">
                            Отмена
                        </button>
                    </div>
                </div>

            </form>

        </div>

    </div>
</template>

<script>
export default {
    name: "PasswordChangeComponent"
}
</script>

<style scoped>

</style>
