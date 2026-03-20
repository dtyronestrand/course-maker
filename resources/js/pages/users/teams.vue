<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-row justify-between">
            <h1 class="pt-4 text-3xl">Teams</h1>
            <div v-if="props.user_role === 'admin'" class="max-w-sm py-4">
                <Button class="glass" @click="addTeam">+ Teams</Button>
            </div>
        </div>
        <div
            v-if="teamsArray.length > 0"
            class="flex flex-row flex-wrap justify-evenly gap-8 p-4"
        >
            <div
                v-for="team in teamsArray"
                :key="team.id"
                class="glass group mb-4 flex-1 rounded p-4"
            >
                <div v-if="edit !== team.id">
                    <div
                        class="flex flex-row justify-end opacity-0 group-hover:opacity-100"
                    >
                        <Pencil role="button" @click="startEdit(team)" />
                    </div>
                    <h3 class="mb-2 text-xl font-semibold text-amber-500">
                        {{ team.name }}
                    </h3>
                    <div class="mb-4 flex flex-col items-center">
                        <UserInfo
                            role="uppercase"
                            avatar="lg"
                            v-if="
                                team.users.find(
                                    (user: User) => user.role === 'lead',
                                )
                            "
                            :user="
                                team.users.find(
                                    (user: User) => user.role === 'lead',
                                )!
                            "
                            :user_role="'lead'"
                        />
                    </div>
                    <h3 class="text-lg uppercase">Ids:</h3>
                    <div class="flex-rowflex-wrap mt-4 flex gap-4">
                        <UserInfo
                            v-for="user in team.users.filter(
                                (user: User) => user.role === 'id',
                            )"
                            :key="user.id"
                            role="hidden"
                            avatar="lg"
                            :user="user"
                            :user_role="'id'"
                        />
                    </div>
                </div>
                <div v-else>
                    <form @submit.prevent="updateTeam">
                        <label for="name" class="mb-2 block">Team Name</label>
                        <input
                            v-model="editForm.name"
                            type="text"
                            class="mb-4 w-min rounded border border-gray-300 p-2"
                            required
                        />
                        <div class="mb-4 flex flex-col items-center">
                            <label for="lead" class="mb-2 block"
                                >Select Lead</label
                            >
                            <select
                                v-model="editForm.lead"
                                class="mb-4 w-full rounded border border-gray-300 p-2"
                            >
                                <option value="null">Unassigned</option>
                                <option
                                    v-for="lead in availableLeads"
                                    :key="lead.id"
                                    :value="lead.id"
                                >
                                    {{ lead.name }}
                                </option>
                            </select>
                        </div>

                        <label for="ids" class="mb-2 block">Select Ids</label>
                        <select
                            v-model="editForm.ids"
                            multiple
                            class="mb-4 w-full rounded border border-gray-300 p-2"
                        >
                            <option
                                v-for="id in ids"
                                :key="id.id"
                                :value="id.id"
                            >
                                {{ id.name }}
                            </option>
                        </select>
                        <Button class="glass bg-red-500" @click="edit = null"
                            >Cancel</Button
                        >
                        <Button class="glass" @click="updateTeam"
                            >Update</Button
                        >
                    </form>
                </div>
            </div>
        </div>

        <Modal title="Create Team" :visible="visible" @close="visible = false">
            <template #header>
                <h3>Create Team</h3>
            </template>
            <template #body>
                <form @submit.prevent="createTeam">
                    <label for="name" class="mb-2 block">Team Name</label>
                    <input
                        v-model="form.name"
                        type="text"
                        id="name"
                        class="mb-4 w-full rounded border border-gray-300 p-2"
                        required
                    />
                    <h4 class="mb-2 block">Add Members</h4>
                    <label for="lead" class="mb-2 block">Select Lead</label>
                    <select
                        v-model="form.lead"
                        class="mb-4 w-full rounded border border-gray-300 p-2"
                    >
                        <option value="null">Unassigned</option>
                        <option
                            v-for="lead in leads"
                            :key="lead.id"
                            :value="lead.id"
                        >
                            {{ lead.name }}
                        </option>
                    </select>
                    <label for="ids" class="mb-2 block">Select Ids</label>
                    <select
                        v-model="form.ids"
                        multiple
                        class="mb-4 w-full rounded border border-gray-300 p-2"
                    >
                        <option v-for="id in ids" :key="id.id" :value="id.id">
                            {{ id.name }}
                        </option>
                    </select>
                </form>
            </template>
            <template #footer>
                <button
                    @click="createTeam"
                    class="rounded bg-blue-500 p-2 text-white"
                >
                    Create
                </button>
                <button
                    @click="visible = false"
                    class="ml-2 rounded bg-gray-500 p-2 text-white"
                >
                    Cancel
                </button>
            </template>
        </Modal>
    </AppLayout>
</template>

<script setup lang="ts">
import type { User } from '@/types/auth';
import type { Team } from '@/types';
import Modal from '@/components/Modal.vue';
import type { BreadcrumbItem } from '@/types';
import Button from '@/components/ui/button/Button.vue';
import { usePage, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { dashboard } from '@/routes';
import { index, teams as teamsRoute } from '@/routes/users';
import AppLayout from '@/layouts/AppLayout.vue';
import UserInfo from '@/components/userinfo/UserInfo.vue';
import { Pencil } from 'lucide-vue-next';
const page = usePage();
const breadcrumbs = computed<BreadcrumbItem[]>(() => {
    return [
        {
            title: 'Dashboard',
            href: dashboard().url,
        },
        {
            title:
                (page.props.user_role as string) === 'lead' ? 'Team' : 'Users',
            href: index().url,
        },
        {
            title: 'Teams',
            href: teamsRoute().url,
        },
    ];
});
const form = useForm({
    name: '',
    lead: null as number | null,
    ids: [] as number[],
    users: [] as number[],
});
const edit = ref<number | null>(null);
const editForm = useForm({
    name: '',
    lead: null as number | null,
    ids: [] as number[],
    users: [] as number[] | [],
});
const availableLeads = computed(() => {
    if (edit.value === null) return [];
    const currentTeam = teamsArray.value.find((t) => t.id === edit.value);
    const currentLeadId = currentTeam?.users.find(
        (user) => user.role === 'lead',
    )?.id;
    return props.users.filter(
        (user) =>
            user.role === 'lead' &&
            (user.current_team_id === null || user.id === currentLeadId),
    );
});
const leads = computed(() => {
    return props.users.filter(
        (user) => user.role === 'lead' && user.current_team_id === null,
    );
});
const ids = computed(() => {
    return props.users.filter((user) => user.role === 'id');
});
const visible = ref(false);
const props = defineProps<{
    users: User[];
    teamsProp: Record<
        number,
        {
            id: number;
            name: string;
            users: User[];
        }
    > | null;
    user_role: 'admin' | 'id' | 'lead' | 'sme';
}>();

const teamsArray = computed(() =>
    props.teamsProp ? Object.values(props.teamsProp) : [],
);
const addTeam = () => {
    visible.value = true;
};
const createTeam = () => {
    form.users = [form.lead as number, ...form.ids];
    form.post('/teams');
    visible.value = false;
    form.reset();
};
const startEdit = (team: Team) => {
    edit.value = team.id;
    editForm.name = team.name;
    editForm.lead = team.users.find((user) => user.role === 'lead')?.id || null;
    editForm.ids = team.users
        .filter((user) => user.role === 'id')
        .map((user) => user.id);
};
const updateTeam = () => {
    editForm.users = [editForm.lead as number, ...editForm.ids];
    editForm.put(`/teams/${edit.value}`);
    edit.value = null;
};
</script>

<style scoped></style>
