<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router, useForm } from "@inertiajs/vue3";
import { ref, computed, watch, onMounted } from "vue";
import Modal from "@/Components/Modal.vue";

const props = defineProps({
    users: {
        type: Object,
        required: true,
        default: () => ({ data: [], links: [] })
    }
});

const search = ref("");
const timeoutId = ref(null);
const isLoading = ref(false);
const currentUsers = ref(props.users);

const formModal = useForm({
    name: "",
    email: "",
    phone: "",
    roles: [],
    is_Banned: false,
}).transform((data) => ({
    ...data,
    is_Banned: data.is_Banned == "1" ? 1 : 0,
}));

const showModal = ref(false);
const idModal = ref(null);
const idItemModal = ref(null);

onMounted(() => {
    // Memastikan data awal sudah dimuat
    if (!currentUsers.value?.data?.length) {
        fetchUsers();
    }
});

const fetchUsers = async (searchQuery = "") => {
    isLoading.value = true;
    try {
        const response = await fetch(route("admin.user.index", { search: searchQuery }));
        const data = await response.json();
        currentUsers.value = data;
    } catch (error) {
        console.error("Failed to fetch users:", error);
    } finally {
        isLoading.value = false;
    }
};

// Debounced search function
watch(search, (newValue) => {
    clearTimeout(timeoutId.value);
    isLoading.value = true;

    timeoutId.value = setTimeout(() => {
        fetchUsers(newValue);
    }, 300);
});

const open = (item, id) => {
    idModal.value = id;
    showModal.value = true;
    idItemModal.value = item.id;

    if (id !== 0) {
        formModal.name = item.name || "";
        formModal.email = item.email || "";
        formModal.phone = item.phone || "";
        formModal.roles = item.roles || [];
        formModal.is_Banned = item.is_Banned;
    }
};

const close = () => {
    showModal.value = false;
    idModal.value = null;
    idItemModal.value = null;
    formModal.reset();
};

const save = () => {
    if (idModal.value === 1) {
        formModal.patch(route("admin.user.update", idItemModal.value), {
            preserveScroll: true,
            onSuccess: () => {
                close();
                fetchUsers(search.value); // Refresh data after update
            },
        });
    } else {
        formModal.delete(route("admin.user.destroy", idItemModal.value), {
            preserveScroll: true,
            onFinish: () => {
                close();
                fetchUsers(search.value); // Refresh data after delete
            },
        });
    }
};

const handlePageChange = async (url) => {
    if (!url) return;

    isLoading.value = true;
    try {
        const response = await fetch(url);
        const data = await response.json();
        currentUsers.value = data;
    } catch (error) {
        console.error("Pagination failed:", error);
    } finally {
        isLoading.value = false;
    }
};

const displayUsers = computed(() => currentUsers.value?.data || []);
const displayLinks = computed(() => currentUsers.value?.links || []);
</script>

<template>
    <Head title="Dashboard Admin" />
    <AuthenticatedLayout>
        <div class="container mx-auto px-4">
            <!-- Search Section -->
            <div class="mb-4">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input
                        type="text"
                        v-model="search"
                        placeholder="Search users by name, email, or phone"
                        class="w-full pl-10 pr-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                </div>
            </div>

            <!-- Loading State -->
            <div v-if="isLoading" class="text-center py-4">
                Loading...
            </div>

            <!-- Users Table -->
            <div v-else-if="displayUsers.length" class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3">Name</th>
                            <th class="px-6 py-3">Phone</th>
                            <th class="px-6 py-3">Role</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in displayUsers" :key="user.id" class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div>
                                    <div class="font-semibold">{{ user.name || 'N/A' }}</div>
                                    <div class="text-gray-500">{{ user.email }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4">{{ user.phone || 'N/A' }}</td>
                            <td class="px-6 py-4">{{ user.roles?.join(', ') || 'No Roles' }}</td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 rounded-full text-xs"
                                    :class="{
                                        'bg-green-100 text-green-800': user.email_verified_at && !user.is_Banned,
                                        'bg-red-100 text-red-800': user.is_Banned,
                                        'bg-yellow-100 text-yellow-800': !user.email_verified_at && !user.is_Banned
                                    }"
                                >
                                    {{ user.is_Banned ? 'Banned' : (user.email_verified_at ? 'Active' : 'Inactive') }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <button
                                    class="text-blue-600 hover:text-blue-900"
                                    @click="open(user, 1)"
                                >
                                    Edit
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Empty State -->
            <div v-else class="text-center py-4 text-gray-500">
                No users found.
            </div>

            <!-- Pagination -->
            <div v-if="displayLinks.length" class="mt-4 flex justify-center space-x-2">
                <button
                    v-for="link in displayLinks"
                    :key="link.label"
                    @click.prevent="handlePageChange(link.url)"
                    :disabled="!link.url || link.active"
                    class="px-3 py-1 rounded-md disabled:opacity-50"
                    :class="{ 'bg-blue-500 text-white': link.active }"
                >
                    <span v-html="link.label"></span>
                </button>
            </div>

            <!-- Edit User Modal -->
            <Modal @close="close" :show="showModal">
                <div class="p-6">
    <h2 class="text-lg font-medium text-gray-900">
        {{ idModal === 1 ? 'Edit User' : 'Delete User' }}
    </h2>

    <div class="mt-6">
        <form @submit.prevent="save">
            <!-- Name Input -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <input
                    type="text"
                    v-model="formModal.name"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    required
                />
                <div v-if="formModal.errors.name" class="text-red-500 text-sm mt-1">
                    {{ formModal.errors.name }}
                </div>
            </div>

            <!-- Email Input -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input
                    type="email"
                    v-model="formModal.email"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    required
                />
                <div v-if="formModal.errors.email" class="text-red-500 text-sm mt-1">
                    {{ formModal.errors.email }}
                </div>
            </div>

            <!-- Phone Input -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Phone</label>
                <input
                    type="text"
                    v-model="formModal.phone"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                />
                <div v-if="formModal.errors.phone" class="text-red-500 text-sm mt-1">
                    {{ formModal.errors.phone }}
                </div>
            </div>

            <!-- Roles Selection -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Roles</label>
                <select
                    v-model="formModal.roles"
                    multiple
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                    <option value="keuangan">Keuangan</option>
                </select>
                <div v-if="formModal.errors.roles" class="text-red-500 text-sm mt-1">
                    {{ formModal.errors.roles }}
                </div>
            </div>

            <!-- Ban Status -->
            <div class="mb-4">
                <label class="flex items-center">
                    <input
                        type="checkbox"
                        v-model="formModal.is_Banned"
                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    />
                    <span class="ml-2 text-sm text-gray-600">Ban User</span>
                </label>
            </div>

            <!-- Modal Footer -->
            <div class="mt-6 flex justify-end space-x-3">
                <button
                    type="button"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    @click="close"
                >
                    Cancel
                </button>
                <button
                    type="submit"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    :disabled="formModal.processing"
                >
                    {{ formModal.processing ? 'Saving...' : 'Save Changes' }}
                </button>
            </div>
        </form>
    </div>
</div>
            </Modal>
        </div>
    </AuthenticatedLayout>
</template>
