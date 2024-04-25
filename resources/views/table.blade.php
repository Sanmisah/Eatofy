<x-layout.menu>    
    <div x-data="notes">
        <div class="flex gap-5 relative sm:h-[calc(100vh_-_150px)] h-full">
            <div class="bg-black/60 z-10 w-full h-full rounded-md absolute hidden"
                :class="{ '!block xl:!hidden': isShowNoteMenu }" @click="isShowNoteMenu = !isShowNoteMenu"></div>
            <div class="panel p-4 flex-none w-[240px] absolute xl:relative z-10 space-y-4 h-full xl:h-auto hidden xl:block ltr:lg:rounded-r-md ltr:rounded-r-none rtl:lg:rounded-l-md rtl:rounded-l-none overflow-hidden"
                :class="{ 'hidden shadow': !isShowNoteMenu, 'h-full ltr:left-0 rtl:right-0': isShowNoteMenu }">
                <div class="flex flex-col h-full pb-16">
                    <div class="flex text-center items-center">
                        <div class="shrink-0">

                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
                                <path
                                    d="M20.3116 12.6473L20.8293 10.7154C21.4335 8.46034 21.7356 7.3328 21.5081 6.35703C21.3285 5.58657 20.9244 4.88668 20.347 4.34587C19.6157 3.66095 18.4881 3.35883 16.2331 2.75458C13.978 2.15033 12.8504 1.84821 11.8747 2.07573C11.1042 2.25537 10.4043 2.65945 9.86351 3.23687C9.27709 3.86298 8.97128 4.77957 8.51621 6.44561C8.43979 6.7254 8.35915 7.02633 8.27227 7.35057L8.27222 7.35077L7.75458 9.28263C7.15033 11.5377 6.84821 12.6652 7.07573 13.641C7.25537 14.4115 7.65945 15.1114 8.23687 15.6522C8.96815 16.3371 10.0957 16.6392 12.3508 17.2435L12.3508 17.2435C14.3834 17.7881 15.4999 18.0873 16.415 17.9744C16.5152 17.9621 16.6129 17.9448 16.7092 17.9223C17.4796 17.7427 18.1795 17.3386 18.7203 16.7612C19.4052 16.0299 19.7074 14.9024 20.3116 12.6473Z"
                                    stroke="currentColor" stroke-width="1.5" />
                                <path opacity="0.5"
                                    d="M16.415 17.9741C16.2065 18.6126 15.8399 19.1902 15.347 19.6519C14.6157 20.3368 13.4881 20.6389 11.2331 21.2432C8.97798 21.8474 7.85044 22.1495 6.87466 21.922C6.10421 21.7424 5.40432 21.3383 4.86351 20.7609C4.17859 20.0296 3.87647 18.9021 3.27222 16.647L2.75458 14.7151C2.15033 12.46 1.84821 11.3325 2.07573 10.3567C2.25537 9.58627 2.65945 8.88638 3.23687 8.34557C3.96815 7.66065 5.09569 7.35853 7.35077 6.75428C7.77741 6.63996 8.16368 6.53646 8.51621 6.44531"
                                    stroke="currentColor" stroke-width="1.5" />
                                <path d="M11.7769 10L16.6065 11.2941" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" />
                                <path opacity="0.5" d="M11 12.8975L13.8978 13.6739" stroke="currentColor"
                                    stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold ltr:ml-3 rtl:mr-3">Menu</h3>
                    </div>
                    <div class="h-px w-full border-b border-[#e0e6ed] dark:border-[#1b2e4b] my-4"></div>
                    <div class="perfect-scrollbar relative pr-3.5 -mr-3.5 h-full grow">
                        <div class="space-y-1">
                            <button type="button"
                                class="w-full flex items-center h-10 p-1 hover:bg-white-dark/10 rounded-md dark:hover:bg-[#181F32] font-medium text-primary ltr:hover:pl-3 rtl:hover:pr-3 duration-300"
                                :class="{ 'ltr:pl-3 rtl:pr-3 bg-gray-100 dark:bg-[#181F32]': selectedTab === 'personal' }"
                                @click="tabChanged('personal')">

                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 rotate-45 fill-primary shrink-0">
                                    <path
                                        d="M2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12Z"
                                        stroke="currentColor" stroke-width="1.5"></path>
                                </svg>
                                <div class="ltr:ml-3 rtl:mr-3">Personal</div>                                
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel flex-1 overflow-auto h-full">
                <div class="pb-5">
                    <button type="button" class="xl:hidden hover:text-primary"
                        @click="isShowNoteMenu = !isShowNoteMenu">

                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg" class="w-6 h-6">
                            <path d="M20 7L4 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                            </path>
                            <path opacity="0.5" d="M20 12L4 12" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round"></path>
                            <path d="M20 17L4 17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                            </path>
                        </svg>
                    </button>
                </div>
                <template x-if="filterdNotesList.length">
                    <div class="sm:min-h-[1000px] min-h-[1000px]">
                        <div class="grid grid-cols-6 gap-3">
                            <template x-for="note in filterdNotesList" :key="note.id">
                                <div class="panel w-32"
                                    :class="{
                                        'bg-primary-light shadow-primary': note.tag === 'personal',
                                        'dark:shadow-dark': !note.tag
                                    }">
                                    <div class="min-h-[10px]">
                                        <div class="flex justify-between">
                                            <div class="flex items-center w-max">
                                                <div class="ltr:ml-2 rtl:mr-2">
                                                    <div class="font-semibold" x-text="note.user"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                            </template>
                        </div>
                    </div>
                </template> 
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("notes", () => ({
                defaultParams: {
                    id: null,
                    title: '',
                    description: '',
                    tag: '',
                    user: '',
                    thumb: ''
                },
                isAddNoteModal: false,
                isDeleteNoteModal: false,
                isViewNoteModal: false,
                params: {
                    id: null,
                    title: '',
                    description: '',
                    tag: '',
                    user: '',
                    thumb: '',
                },
                isShowNoteMenu: false,
                notesList: [{
                        id: 1,
                        user: 'Max Smith',
                        thumb: 'profile-16.jpeg',
                        title: 'Meeting with Kelly',
                        description: 'Curabitur facilisis vel elit sed dapibus sodales purus rhoncus.',
                        date: '11/01/2020',
                        isFav: false,
                        tag: 'personal',
                    },
                    {
                        id: 20,
                        user: 'Kathleen Flores',
                        thumb: 'profile-34.jpeg',
                        title: "Take cat on a walk",
                        description: 'Baseball ipsum dolor sit amet cellar rubber win hack tossed. ',
                        date: '11/18/2020',
                        isFav: false,
                        tag: 'personal'
                    },
                    {
                        id: 2,
                        user: 'John Doe',
                        thumb: 'profile-14.jpeg',
                        title: 'Receive Package',
                        description: 'Facilisis curabitur facilisis vel elit sed dapibus sodales purus.',
                        date: '11/02/2020',
                        isFav: true,
                        tag: 'personal',
                    },
                    {
                        id: 3,
                        user: 'Kia Jain',
                        thumb: 'profile-15.jpeg',
                        title: 'Download Docs',
                        description: 'Proin a dui malesuada, laoreet mi vel, imperdiet diam quam laoreet.',
                        date: '11/04/2020',
                        isFav: false,
                        tag: 'personal',
                    },
                    {
                        id: 4,
                        user: 'Max Smith',
                        thumb: 'profile-16.jpeg',
                        title: 'Meeting at 4:50pm',
                        description: 'Excepteur sint occaecat cupidatat non proident, anim id est laborum.',
                        date: '11/08/2020',
                        isFav: false,
                        tag: 'personal',
                    },
                    {
                        id: 5,
                        user: 'Karena Courtliff',
                        thumb: 'profile-17.jpeg',
                        title: 'Backup Files EOD',
                        description: 'Maecenas condimentum neque mollis, egestas leo ut, gravida.',
                        date: '11/09/2020',
                        isFav: false,
                        tag: 'personal',
                    },
                    {
                        id: 6,
                        user: 'Max Smith',
                        thumb: 'profile-16.jpeg',
                        title: 'Download Server Logs',
                        description: 'Suspendisse efficitur diam quis gravida. Nunc molestie est eros.',
                        date: '11/09/2020',
                        isFav: false,
                        tag: 'personal',
                    },
                    {
                        id: 7,
                        user: 'Vladamir Koschek',
                        thumb: '',
                        title: 'Team meet at Starbucks',
                        description: 'Etiam a odio eget enim aliquet laoreet lobortis sed ornare nibh.',
                        date: '11/10/2020',
                        isFav: false,
                        tag: 'personal',
                    },
                    {
                        id: 8,
                        user: 'Max Smith',
                        thumb: 'profile-16.jpeg',
                        title: 'Create new users Profile',
                        description: 'Duis aute irure in nulla pariatur. Etiam a odio eget enim aliquet.',
                        date: '11/11/2020',
                        isFav: false,
                        tag: 'personal',
                    },
                    {
                        id: 9,
                        user: 'Robert Garcia',
                        thumb: 'profile-21.jpeg',
                        title: "Create a compost pile",
                        description: 'Zombie ipsum reversus ab viral inferno, nam rick grimes malum cerebro.',
                        date: '11/12/2020',
                        isFav: true,
                        tag: 'personal'
                    },
                    {
                        id: 10,
                        user: 'Marie Hamilton',
                        thumb: 'profile-2.jpeg',
                        title: "Take a hike at a local park",
                        description: 'De carne lumbering animata corpora quaeritis. Summus brains sit',
                        date: '11/13/2020',
                        isFav: true,
                        tag: 'personal'
                    },
                    {
                        id: 11,
                        user: 'Megan Meyers',
                        thumb: 'profile-1.jpeg',
                        title: "Take a class at local community center that interests you",
                        description: 'Cupcake ipsum dolor. Sit amet marshmallow topping cheesecake muffin.',
                        date: '11/13/2020',
                        isFav: false,
                        tag: 'personal'
                    },
                    {
                        id: 12,
                        user: 'Angela Hull',
                        thumb: 'profile-22.jpeg',
                        title: "Research a topic interested in",
                        description: 'Lemon drops tootsie roll marshmallow halvah carrot cake.',
                        date: '11/14/2020',
                        isFav: false,
                        tag: 'personal'
                    },
                    {
                        id: 13,
                        user: 'Karen Wolf',
                        thumb: 'profile-23.jpeg',
                        title: "Plan a trip to another country",
                        description: 'Space, the final frontier. These are the voyages of the Starship Enterprise.',
                        date: '11/16/2020',
                        isFav: true,
                        tag: 'personal'
                    },
                    {
                        id: 14,
                        user: 'Jasmine Barnes',
                        thumb: 'profile-1.jpeg',
                        title: "Improve touch typing",
                        description: 'Well, the way they make shows is, they make one show.',
                        date: '11/16/2020',
                        isFav: false,
                        tag: 'personal'
                    },
                    {
                        id: 15,
                        user: 'Thomas Cox',
                        thumb: 'profile-11.jpeg',
                        title: "Learn Express.js",
                        description: 'Bulbasaur Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                        date: '11/17/2020',
                        isFav: false,
                        tag: 'personal'
                    },
                    {
                        id: 16,
                        user: 'Marcus Jones',
                        thumb: 'profile-12.jpeg',
                        title: "Learn calligraphy",
                        description: 'Ivysaur Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                        date: '11/17/2020',
                        isFav: false,
                        tag: 'personal'
                    },
                    {
                        id: 17,
                        user: 'Matthew Gray',
                        thumb: 'profile-24.jpeg',
                        title: "Have a photo session with some friends",
                        description: 'Venusaur Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                        date: '11/18/2020',
                        isFav: false,
                        tag: 'personal'
                    },
                    {
                        id: 18,
                        user: 'Chad Davis',
                        thumb: 'profile-31.jpeg',
                        title: "Go to the gym",
                        description: 'Charmander Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                        date: '11/18/2020',
                        isFav: false,
                        tag: 'personal'
                    },
                    {
                        id: 19,
                        user: 'Linda Drake',
                        thumb: 'profile-23.jpeg',
                        title: "Make own LEGO creation",
                        description: 'Charmeleon Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                        date: '11/18/2020',
                        isFav: false,
                        tag: 'personal'
                    }
                ],
                filterdNotesList: '',
                selectedTab: 'all',
                deletedNote: null,
                selectedNote: {
                    id: null,
                    title: '',
                    description: '',
                    tag: '',
                    user: '',
                    thumb: ''
                },

                init() {
                    this.searchNotes();
                },

                searchNotes() {
                    if (this.selectedTab != 'fav') {
                        if (this.selectedTab != 'all' || this.selectedTab === 'delete') {
                            this.filterdNotesList = this.notesList.filter((d) => d.tag === this
                                .selectedTab);
                        } else {
                            this.filterdNotesList = this.notesList;
                        }
                    } else {
                        this.filterdNotesList = this.notesList.filter((d) => d.isFav);
                    }
                },

                tabChanged(type) {
                    this.selectedTab = type;
                    this.searchNotes();
                    this.isShowNoteMenu = false;
                },
            }));
        });
    </script>
</x-layout.menu>
