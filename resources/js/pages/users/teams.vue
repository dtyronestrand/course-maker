<template>
    <AppLayout>
    <div v-if="props.user_role === 'admin'" class="py-4 max-w-sm">
    <Button class="glass" @click="addTeam">+ Teams</Button>
    </div>
    <div v-if="teamsArray.length > 0" class=" flex flex-row flex-wrap gap-8 justify-evenly p-4">
   
    <div v-for="team in teamsArray" :key="team.id" class="glass group flex-1 p-4 rounded mb-4">
     <div v-if="edit !== team.id">
     <div class="opacity-0 group-hover:opacity-100 flex flex-row justify-end"><Pencil role="button" @click="startEdit(team)"/></div>
        <h3 class="text-xl text-amber-500 font-semibold mb-2">{{ team.name }}</h3>
        <div class="flex flex-col items-center mb-4">
        <UserInfo role="uppercase" avatar="lg" v-if="team.users.find((user: User) => user.role === 'lead')" :user="team.users.find((user: User) => user.role === 'lead')!" :user_role="'lead'" />
        </div>
        <h3 class="uppercase text-lg">Ids:</h3>
      <div class="flex flex-wrap justify-evenly items-center gap-4 mb-2 grow">
        <UserInfo v-for="user in team.users.filter((user: User) => user.role === 'id')" :key="user.id" role="hidden" avatar="lg" :user="user" :user_role="'id'" />
      </div>
     </div>
     <div v-else>
     <form @submit.prevent="updateTeam">
        <label for="name" class="block mb-2">Team Name</label>
        <input v-model="editForm.name" type="text" class="w-min p-2 border border-gray-300 rounded mb-4" required>
          <div class="flex flex-col items-center mb-4">
<label for="lead" class="block mb-2">Select Lead</label>
    <select  v-model="editForm.lead" class="w-full p-2 border border-gray-300 rounded mb-4">
    <option value="null">Unassigned</option>
        <option v-for="lead in availableLeads" :key="lead.id" :value="lead.id">{{ lead.name }}</option>
    </select>
        </div>
     
      
        <label for="ids" class="block mb-2">Select Ids</label>
    <select v-model="editForm.ids" multiple class="w-full p-2 border border-gray-300 rounded mb-4">
        <option v-for="id in ids" :key="id.id" :value="id.id">{{ id.name }}</option>
    </select>
    <Button class="glass bg-red-500" @click="edit=null">Cancel</Button>
    <Button class="glass" @click="updateTeam">Update</Button>
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
    <label for="name" class="block mb-2">Team Name</label>
    <input v-model="form.name" type="text" id="name" class="w-full p-2 border border-gray-300 rounded mb-4" required>
    <h4  class="block mb-2">Add Members</h4>
    <label for="lead" class="block mb-2">Select Lead</label>
    <select  v-model="form.lead" class="w-full p-2 border border-gray-300 rounded mb-4">
    <option value="null">Unassigned</option>
        <option v-for="lead in leads" :key="lead.id" :value="lead.id">{{ lead.name }}</option>
        
    </select>
    <label for="ids" class="block mb-2">Select Ids</label>
    <select v-model="form.ids" multiple class="w-full p-2 border border-gray-300 rounded mb-4">
        <option v-for="id in ids" :key="id.id" :value="id.id">{{ id.name }}</option>
    </select>
    </form>
    </template>
    <template #footer>
    <button @click="createTeam" class="p-2 bg-blue-500 text-white rounded">Create</button>
    <button @click="visible = false" class="p-2 bg-gray-500 text-white rounded ml-2">Cancel</button>
    </template>
    </Modal>
    </AppLayout>
</template>

<script setup lang="ts">
import type { User } from '@/types/auth';
import type { Team } from '@/types/global';
import Modal from '@/components/Modal.vue';
import Button from '@/components/ui/button/Button.vue';
import { usePage, useForm } from '@inertiajs/vue3';
import {ref, computed} from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import UserInfo from '@/components/userinfo/UserInfo.vue';
import {Pencil} from 'lucide-vue-next';
const page = usePage<{
    teams: {
        id: number;
        name: string;
        users: User[];
    }[] | null;
}>();
const form = useForm({
    name: '',
    lead: null as number | null,
    ids: [] as number[],
    users: [] as number[],
})
const edit = ref<number | null>(null);
const editForm = useForm({
    name: '',
    lead: null as number | null,
    ids: [] as number[],
})
const availableLeads = computed(() => {
    if (edit.value === null) return [];
    const currentTeam = teamsArray.value.find(t => t.id === edit.value);
    const currentLeadId = currentTeam?.users.find(user => user.role === 'lead')?.id;
    return props.users.filter(user => 
        user.role === 'lead' && 
        (user.current_team_id === null || user.id === currentLeadId)
    );
})
const leads= computed(() => {
    return props.users.filter(user => user.role === 'lead' && user.current_team_id === null);
})
const ids = computed(() => {
    return props.users.filter(user => user.role === 'id');
})
const visible = ref(false);
const props = defineProps<{
    users: User[];
    teams: Record<number, {
        id: number;
        name: string;
        users: User[];
    }> | null;
    user_role: 'admin' | 'id' | 'lead' | 'sme';
}>();

const teamsArray = computed(() => props.teams ? Object.values(props.teams) : []);
 const addTeam = () => {
    visible.value = true;
 }
 const createTeam = () => {
    form.users = [form.lead as number, ...form.ids];
    form.post('/teams');
    visible.value = false;
    form.reset();
 }
 const startEdit = (team: Team) => {
    edit.value = team.id;
    editForm.name = team.name;
    editForm.lead = team.users.find(user => user.role === 'lead')?.id || null;
    editForm.ids = team.users.filter(user => user.role === 'id').map(user => user.id);
 }
 const updateTeam = () => {
    // Implement team update logic here
    edit.value = null;
 }
</script>

<style scoped>

</style>