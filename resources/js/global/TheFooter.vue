<template>
    <div class="the-footer-global px-12">
        <div
            class="the-footer w-full max-h-56 sm:h-40 md:h-24 py-4 space-y-5 rounded-t-lg"
        >
            <div
                class="grid grid-flow-row gap-0 auto-rows-max text-center sm:flex sm:flex-row sm:flex-wrap justify-center  sm:space-x-7"
            >
                <div class="footer-link">
                    <router-link to="">Mentions légales</router-link>
                </div>
                <div class="footer-link">
                    <router-link to=""
                        >Politique de confidentialité</router-link
                    >
                </div>
                <div class="footer-link">
                    <router-link to="">A propos & FAQ</router-link>
                </div>
                <div class="footer-link">
                    <router-link to="">Conditions de vente</router-link>
                </div>
            </div>
            <div
                class="flex flex-row flex-wrap justify-center space-x-3 sm:space-x-7"
            >
                <div class="footer-link flex flex-row content-center space-x-2">
                    <span
                        ><img
                            :src="pathImgFooter + '/linkedin-square.png'"
                            alt=""
                    /></span>
                    <span class="mt-1 hidden sm:block"
                        ><router-link to="">Linkedin</router-link></span
                    >
                </div>
                <div class="footer-link flex flex-row content-center space-x-2">
                    <span
                        ><img
                            :src="pathImgFooter + '/facebook-square.png'"
                            alt=""
                    /></span>
                    <span class="mt-1 hidden sm:block"
                        ><router-link to="">Facebook</router-link></span
                    >
                </div>
                <div class="footer-link flex flex-row content-center space-x-2">
                    <span
                        ><img
                            :src="pathImgFooter + '/twitter-square.png'"
                            alt=""
                    /></span>
                    <span class="mt-1 hidden sm:block"
                        ><router-link to="">Twiter</router-link></span
                    >
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "the-footer"
};
</script>

<style></style>
