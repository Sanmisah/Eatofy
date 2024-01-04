<x-layout.default>

    <div x-data="contacts">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <h2 class="text-xl">Contacts</h2>
            <div class="flex sm:flex-row flex-col sm:items-center sm:gap-3 gap-4 w-full sm:w-auto">
                <div class="flex gap-3">
                    <div>
                        <button type="button" class="btn btn-primary" @click="editUser">

                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2">
                                <circle cx="10" cy="6" r="4" stroke="currentColor"
                                    stroke-width="1.5" />
                                <path opacity="0.5"
                                    d="M18 17.5C18 19.9853 18 22 10 22C2 22 2 19.9853 2 17.5C2 15.0147 5.58172 13 10 13C14.4183 13 18 15.0147 18 17.5Z"
                                    stroke="currentColor" stroke-width="1.5" />
                                <path d="M21 10H19M19 10H17M19 10L19 8M19 10L19 12" stroke="currentColor"
                                    stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                            Add Contact
                        </button>
                        
                    </div>                   
                </div>

                <div class="relative ">
                    <input type="text" placeholder="Search Contacts"
                        class="form-input py-2 ltr:pr-11 rtl:pl-11 peer" x-model="searchUser"
                        @keyup="searchContacts" />
                    <div
                        class="absolute ltr:right-[11px] rtl:left-[11px] top-1/2 -translate-y-1/2 peer-focus:text-primary">

                        <svg class="mx-auto" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <circle cx="11.5" cy="11.5" r="9.5" stroke="currentColor"
                                stroke-width="1.5" opacity="0.5"></circle>
                            <path d="M18.5 18.5L22 22" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5 panel p-0 border-0 overflow-hidden">
            <template x-if="displayType === 'list'">
                <div class="table-responsive">
                    <table class="table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th class="!text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="contact in filterdContactsList" :key="contact.id">
                                <tr>
                                    <td>
                                        <div class="flex items-center w-max">
                                            <div x-show="contact.path" class="w-max">
                                                <img :src="`/assets/images/${contact.path}`"
                                                    class="h-8 w-8 rounded-full object-cover ltr:mr-2 rtl:ml-2"
                                                    alt="avatar" />
                                            </div>
                                            <div x-show="!contact.path && contact.name"
                                                class="grid place-content-center h-8 w-8 ltr:mr-2 rtl:ml-2 rounded-full bg-primary text-white text-sm font-semibold"
                                                x-text="contact.name.charAt(0) + '' + contact.name.charAt(contact.name.indexOf(' ') + 1)">
                                            </div>
                                            <div x-show="!contact.path && !contact.name"
                                                class="border border-gray-300 dark:border-gray-800 rounded-full p-2 ltr:mr-2 rtl:ml-2">

                                                <svg width="24" height="24" viewBox="0 0 24 24"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg"
                                                    class="w-4.5 h-4.5">
                                                    <circle cx="12" cy="6" r="4"
                                                        stroke="currentColor" stroke-width="1.5"></circle>
                                                    <ellipse opacity="0.5" cx="12" cy="17"
                                                        rx="7" ry="4" stroke="currentColor"
                                                        stroke-width="1.5"></ellipse>
                                                </svg>
                                            </div>
                                            <div x-text="contact.name"></div>
                                        </div>
                                    </td>
                                    <td x-text="contact.email"></td>
                                    <td>
                                        <div class="flex gap-4 items-center justify-center">
                                            <a href="{{ route('profile.edit', ['user'=> auth()->user()->id ])  }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                @click="deleteUser(contact)">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </template>
        </div>
     
    </div>

    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("contacts", () => ({
                defaultParams: {
                    id: null,
                    name: '',
                    email: '',
                },
                displayType: 'list',
                addContactModal: false,
                params: {
                    id: null,
                    name: '',
                    email: '',
                },
                filterdContactsList: [],
                searchUser: '',
                contactList: [
                    @if(!empty($users))
                    @foreach($users as $user)
                    {
                        id: 1,
                        name: '{{ $user->name }}',
                        email: '{{ $user->email }}',
                    },
                    @endforeach
                    @endif
                   
                   
               
                  
                ],
                perPage: 10,
                perPageSelect: [10, 20, 30, 50, 100],
                columns: [{
                    select: 0,
                    sort: "asc"
                }, ],
                firstLast: true,
                firstText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M13 19L7 12L13 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M16.9998 19L10.9998 12L16.9998 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                lastText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M11 19L17 12L11 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M6.99976 19L12.9998 12L6.99976 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                prevText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M15 5L9 12L15 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                nextText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                labels: {
                    perPage: "{select}"
                },
                layout: {
                            top: "{search}",
                            bottom: "{info}{select}{pager}",
                        },

                init() {
                    this.searchContacts();
                },

                searchContacts() {
                    this.filterdContactsList = this.contactList.filter((d) => d.name.toLowerCase()
                        .includes(this.searchUser.toLowerCase()));
                },

               

               
            }));
        });
    </script>
</x-layout.default>
