<script setup lang="ts">
import { Form, Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import ProfileController from '@/actions/App/Http/Controllers/Settings/ProfileController';
import DeleteUser from '@/components/DeleteUser.vue';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { edit } from '@/routes/profile';
import { send } from '@/routes/verification';
import type { BreadcrumbItem } from '@/types';

type Props = {
    mustVerifyEmail: boolean;
    status?: string;
};

defineProps<Props>();

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Paramètres du profil',
        href: edit(),
    },
];

const page = usePage();
const user = computed(() => page.props.auth.user);
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Paramètres du profil" />

        <h1 class="sr-only">Paramètres du profil</h1>

        <SettingsLayout>
            <div class="flex flex-col space-y-6">
                <Heading
                    variant="small"
                    title="Informations du profil"
                    description="Modifiez votre nom et votre adresse email"
                />

                <Form
                    v-bind="ProfileController.update.form()"
                    class="space-y-6"
                    v-slot="{ errors, processing, recentlySuccessful }"
                >
                    <div class="grid gap-2">
                        <Label for="name" class="text-sm font-medium">Nom complet</Label>
                        <Input
                            id="name"
                            class="rounded-xl border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green"
                            name="name"
                            :default-value="user.name"
                            required
                            autocomplete="name"
                            placeholder="Jean Dupont"
                        />
                        <InputError :message="errors.name" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="avatar" class="text-sm font-medium">Photo de profil (Avatar)</Label>
                        <Input
                            id="avatar"
                            type="file"
                            accept="image/*"
                            class="rounded-xl border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800"
                            name="avatar"
                            @change="(e) => ProfileController.update.form().avatar = e.target.files[0]"
                        />
                        <InputError :message="errors.avatar" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="email" class="text-sm font-medium">Adresse email</Label>
                        <Input
                            id="email"
                            type="email"
                            class="rounded-xl border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green"
                            name="email"
                            :default-value="user.email"
                            required
                            autocomplete="username"
                            placeholder="exemple@raosc.org"
                        />
                        <InputError :message="errors.email" />
                    </div>

                    <div v-if="mustVerifyEmail && !user.email_verified_at">
                        <p class="-mt-4 text-sm text-zinc-500 dark:text-zinc-400">
                            Votre adresse email n'est pas vérifiée.
                            <Link
                                :href="send()"
                                as="button"
                                class="text-raosc-green font-semibold hover:text-raosc-green/80 transition-colors"
                            >
                                Cliquez ici pour renvoyer l'email de vérification.
                            </Link>
                        </p>

                        <div
                            v-if="status === 'verification-link-sent'"
                            class="mt-2 text-sm font-medium text-emerald-600 dark:text-emerald-400"
                        >
                            Un nouveau lien de vérification a été envoyé à votre adresse email.
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <Button
                            type="submit"
                            :disabled="processing"
                            class="bg-raosc-green hover:bg-raosc-green/90 text-white font-semibold rounded-full px-6 py-2.5 shadow-sm transition-all"
                            data-test="update-profile-button"
                        >
                            Enregistrer
                        </Button>

                        <Transition
                            enter-active-class="transition ease-in-out"
                            enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out"
                            leave-to-class="opacity-0"
                        >
                            <p
                                v-show="recentlySuccessful"
                                class="text-sm text-emerald-600 dark:text-emerald-400"
                            >
                                Enregistré.
                            </p>
                        </Transition>
                    </div>
                </Form>
            </div>

            <DeleteUser />
        </SettingsLayout>
    </AppLayout>
</template>