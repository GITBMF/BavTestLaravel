<template>
    <header
        ref="header1"
        class="header header-home"
        :style="bgChange"
        :class="{
            whiteText: isTextWhite,
            transitPart2Up: this.ScrollDown,
            transitPart2Down: this.ScrollUp,
            contactBg: $route.name == 'contact'
        }"
    >
        <div
            v-if="isHeader"
            class="moi transit absolute text-center text-base w-full text-white flex-col z-30 block md:hidden"
        >
            <nav
                @click="isHeader = false"
                class="flex justify-end pr-3 mx-auto leading-snug"
            >
                <span class="inline-block text-6xl font-normal rotLil">+</span>
            </nav>
            <nav>
                <router-link :to="{ name: 'accueil' }">
                    <nav class="text-white font-bold fontB py-4">Accueil</nav>
                </router-link>
            </nav>

            <nav @click="showServices = !showServices">
                <nav class="text-white font-bold fontB py-4">
                    Services
                    <span
                        class="inline-block border-b-2 border-r-2 border-white cursor-pointer h-2 w-2 ml-2 rot45 mar-T"
                        :class="{ rot135: showServices }"
                    ></span>
                    <service-drop-down
                        @closeHeader="isHeader = false"
                        :showS.sync="showServices"
                        @close="showServices = false"
                    ></service-drop-down>
                </nav>
            </nav>
            <nav>
                <router-link :to="{ name: 'contact' }">
                    <nav class="text-white font-bold fontB py-4">Contact</nav>
                </router-link>
            </nav>

            <nav class="py-4">
                <div @click="isHeader = false">
                    <button
                        @click="changeDemanderDevis"
                        class="btn-header fontB bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-8 rounded"
                    >
                        Demander Devis
                    </button>
                </div>
            </nav>
        </div>
        <div class="container relative bg-transparent">
            <div class="main justify-between">
                <div class="nav-wrapper flex justify-between">
                    <div class="mr-1">
                        <router-link class :to="{ name: 'accueil' }">
                            <div class="logo">
                                <img
                                    v-if="showTHeader"
                                    v-lazy="pathImg + 'Plan.png'"
                                    class="h-16"
                                />
                                <img
                                    v-else
                                    v-lazy="pathImg + 'Plan.png'"
                                    class="h-16"
                                />
                            </div>
                        </router-link>
                    </div>

                    <div class="hidden md:flex justify-around my-auto">
                        <router-link
                            class="flex mx-2 fontB"
                            :to="{ name: 'accueil' }"
                        >
                            <span>Accueil</span>
                        </router-link>
                        <nav
                            :class="{
                                addBorderB: $route.path.includes('service')
                            }"
                            class="flex text-black mx-2 fontB servNav md:relative"
                            @mouseover="showServices = true"
                            @mouseleave="showServices = false"
                        >
                            <span class="cursor-pointer">Services</span>
                            <span class="flex">
                                <!-- <i class="fa fa-check" aria-hidden="true"></i> -->
                                <span
                                    class="inline-block border-b-2 border-r-2 border-black cursor-pointer h-2 w-2 ml-2 rot45 marT"
                                    :class="{ rot135: showServices }"
                                ></span>
                            </span>
                            <!-- Hidden sevices popup here -->
                            <!-- <service-drop-down
                :showS.sync="showServices"
                @close="showServices = false"
              ></service-drop-down> -->
                        </nav>
                        <router-link
                            class="flex mx-2 fontB"
                            :to="{ name: 'contact' }"
                        >
                            <span>Contact</span>
                        </router-link>
                    </div>
                </div>
                <div
                    @click="isHeader = true"
                    class="hidden md:inline-block self-center"
                >
                    <button
                        @click="changeDemanderDevis"
                        class="fade fontB btn-header text-black rounded-lg pl-4 pr-4 py-1 px-1 whitespace-no-wrap"
                        :class="{
                            'bg-white': isTextWhite,
                            'bg-gray-300': !isTextWhite
                        }"
                    >
                        Demander Devis
                    </button>
                </div>

                <i
                    class="text-black hovTarget material-icons icon-close-header"
                    @click="isHeader = true"
                    >menu</i
                >
            </div>
        </div>
        <indicator class="styleMe w-0"></indicator>
    </header>
</template>

<script>
import { mapState, mapActions, mapGetters } from "vuex";
// import serviceDropDown from "./block/block-services-dropdown";

export default {
    name:"fix-header",
    props: {
        logo_name: {
            type: String,
            default: "/img/Plan.png"
        },
        closed: {
            type: Boolean,
            default: false
        }
    },
    components: {
        // serviceDropDown,
    },

    data() {
        return {
            bgChange: "",
            isHeader: false,
            ScrollUp: false,
            ScrollDown: false,
            showServices: false,
            isTextWhite: true,
            showTHeader: null,
            // scrollUpFast: false,

            constScrollPos: 0,
            changingScrollPos: 0,
            currentBackground: "backgroundYellow"
            // activeClass: "active"
        };
    },

    computed: {
        ...mapGetters("demander", ["getIsDemanderDevis"]),
        ...mapGetters("header", ["currentSlide"])
    },

    mounted() {
        let app = this;

        window.onresize = function() {
            if (window.innerWidth >= 769) {
                this.isHeader = true;
            }
            if (window.innerWidth < 769) {
                this.isHeader = false;
            }
        };

        var vm = this;
        console.log("path-----", vm.$route.path);
        if (
            vm.$route.path == "/formation2" ||
            vm.$route.path == "/offres" ||
            vm.$route.path == "/contacternous"
        ) {
            vm.isTextWhite = false;
        } else {
            vm.showTHeader = true;
        }
        window.addEventListener("scroll", function(e) {
            // var scrollPos = window.scrollY;

            vm.changingScrollPos = document.scrollingElement.scrollTop;
            if (vm.$route.path != "/contacternous") {
                if (
                    vm.$route.path != "/formation2" &&
                    vm.$route.path != "/offres" &&
                    vm.changingScrollPos < 10
                ) {
                    if (vm.$route.path == "/service/siteweb") {
                        vm.isTextWhite = false;
                        vm.bgChange = "color:black";
                    } else {
                        vm.bgChange = "background:transparent; color:white";
                        vm.isTextWhite = true;
                    }
                    vm.showTHeader = true;
                } else {
                    vm.bgChange = "background:white";
                    vm.isTextWhite = false;
                    vm.showTHeader = false;
                }

                if (vm.constScrollPos === 0) {
                    vm.constScrollPos = document.scrollingElement.scrollTop;
                }
            }
            if (vm.changingScrollPos > vm.constScrollPos) {
                if (vm.changingScrollPos > 500) {
                    if (vm.isHeader === false) {
                        vm.scrollingDown();
                    }
                }
            }

            if (vm.changingScrollPos < vm.constScrollPos) {
                // if (vm.changingScrollPos < 467) {
                //   vm.scrollUpFast = true;
                // }
                if (vm.changingScrollPos > 400) {
                    if (vm.isHeader === false) {
                        vm.scrollingUp();
                    }
                }
            }
            // vm.scrollUpFast = false;
            vm.constScrollPos = vm.changingScrollPos;
        });
    },
    watch: {
        $route: {
            immediate: true,
            deep: true,
            handler() {
                var vm = this;
                console.log("path-----", vm.$route.path);
                if (vm.$route.path == "/contacternous") {
                    vm.isTextWhite = false;
                    vm.bgChange = "background:white; color:black";
                    vm.showTHeader = false;
                }
                if (vm.$route.path == "/service/siteweb") {
                    vm.isTextWhite = false;
                    vm.bgChange = "color:black";
                }
            }
        },
        closed: function() {
            this.isHeader = this.closed;
        },
        isHeader: function() {
            this.$emit("closed", this.isHeader);
        },

        currentSlide(newVal) {
            if (newVal === 0) {
                this.currentBackground = "backgroundYellow";
            } else if (newVal === 1) {
                this.currentBackground = "backgroundDark";
            } else {
                this.currentBackground = "backgroundBrown";
            }
        }
    },
    methods: {
        ...mapActions("demander", ["changeDemanderDevis"]),

        closeHeader: function() {
            this.isHeader = false;
        },
        scrollingUp: function() {
            this.ScrollUp = true;
            this.ScrollDown = false;
        },
        scrollingDown: function() {
            this.ScrollDown = true;
            this.ScrollUp = false;
        }
    }
};
</script>

<style scoped lang="scss">
// @import "/css/home/tailwind.css";
// @import "/css/home/transit.css";

.styleMe {
    background-color: #201101;
}
.whiteText a,
.whiteText .rot45,
.whiteText .servNav {
    color: white !important;
    border-color: white;
}
.header.header-home {
    padding: 0 32px;
}
@media screen and (max-width: 760px) {
    .header.header-home {
        padding: 0;
    }
}
.font-arial {
    transform: rotate(45deg) !important;
}
.rot45 {
    transform: rotate(45deg);
}

.marT {
    margin-top: 5px;
}
.rotLil {
    transform: rotate(45deg) !important;
}
.mar-T {
    transform: translateY(-3px) rotate(45deg);
}
.rot135 {
    animation: rotate 0.3s linear forwards;
}
@keyframes rotate {
    from {
        transform: translateY(0) rotate(45deg);
    }
    50% {
        transform: translateY(2px) rotate(135deg);
    }
    to {
        transform: translateY(4px) rotate(225deg);
    }
}
.router-link-exact-active {
    text-decoration: none;
    /* transition: all 0.1s ease 0s; */
    border-bottom: 3px solid #201101;
}
.addBorderB {
    text-decoration: none;
    border-bottom: 3px solid #201101;
}
.contactBg {
    background: black;
    color: white;
}
.nav-wrapper {
    width: 85%;
}
.nav-wrapper span {
    font-size: 18px;
}
.router-link-exact-active:active {
    border-bottom: 3px solid #ffa200;
    color: #201101;
}
.fade:hover {
    letter-spacing: 1px;
    -webkit-box-shadow: 0px 5px 40px -10px #201101;
    -moz-box-shadow: 0px 5px 40px -10px #201101;
    box-shadow: 5px 40px -10px #201101;
    transition: all 0.5s ease-in;
}
.fade {
    transition: all 0.5s ease-out;
    background: #ffa200;
}

.transitPart2Up {
    animation: scrDown 2s linear forwards;
}
.transitPart2Down {
    animation: scrUp 0.8s linear forwards;
}
.transitScrfast {
    transform: translateY(0px);
}

@keyframes scrDown {
    0% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(0px);
    }
    100% {
        transform: translateY(-70px);
    }
}
@keyframes scrUp {
    0% {
        transform: translateY(-70px);
    }
    100% {
        transform: translateY(0px);
    }
}
@media (min-width: 954px) {
    .header {
        padding-left: 6vw;
        padding-right: 6vw;
    }
}
</style>
