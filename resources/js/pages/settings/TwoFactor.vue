Routing<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import { ShieldBan, ShieldCheck } from 'lucide-vue-next';
import { onUnmounted, ref } from 'vue';
import Heading from '@/components/Heading.vue';
import TwoFactorRecoveryCodes from '@/components/TwoFactorRecoveryCodes.vue';
import TwoFactorSetupModal from '@/components/TwoFactorSetupModal.vue';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { useTwoFactorAuth } from '@/composables/useTwoFactorAuth';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { disable, enable, show } from '@/routes/two-factor';
import type { BreadcrumbItem } from '@/types';

type Props = {
    requiresConfirmation?: boolean;
    twoFactorEnabled?: boolean;
};

withDefaults(defineProps<Props>(), {
    requiresConfirmation: false,
    twoFactorEnabled: false,
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Authentification à deux facteurs',
        href: show(),
    },
];

const { hasSetupData, clearTwoFactorAuthData } = useTwoFactorAuth();
const showSetupModal = ref<boolean>(false);

onUnmounted(() => {
    clearTwoFactorAuthData();
});
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Authentification à deux facteurs" />

        <h1 class="sr-only">Paramètres d'authentification à deux facteurs</h1>

        <SettingsLayout>
            <div class="space-y-6">
                <Heading
                    variant="small"
                    title="Authentification à deux facteurs"
                    description="Gérez vos paramètres de double authentification"
                />

                <div
                    v-if="!twoFactorEnabled"
                    class="flex flex-col items-start justify-start space-y-5"
                >
                    <Badge variant="destructive" class="rounded-full px-3 py-1 text-xs font-semibold">Désactivée</Badge>

                    <p class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed">
                        Lorsque vous activez la double authentification, vous devrez saisir un code de sécurité à chaque connexion.
                        Ce code peut être généré par une application TOTP sur votre téléphone (comme Google Authenticator ou Authy).
                    </p>

                    <div>
                        <Button
                            v-if="hasSetupData"
                            @click="showSetupModal = true"
                            class="bg-raosc-green hover:bg-raosc-green/90 text-white font-semibold rounded-full px-6 py-2.5 shadow-sm transition-all"
                        >
                            <ShieldCheck class="mr-2 h-4 w-4" />
                            Continuer la configuration
                        </Button>
                        <Form
                            v-else
                            v-bind="enable.form()"
                            @success="showSetupModal = true"
                            #default="{ processing }"
                        >
                            <Button
                                type="submit"
                                :disabled="processing"
                                class="bg-raosc-green hover:bg-raosc-green/90 text-white font-semibold rounded-full px-6 py-2.5 shadow-sm transition-all"
                            >
                                <ShieldCheck class="mr-2 h-4 w-4" />
                                Activer la 2FA
                            </Button>
                        </Form>
                    </div>
                </div>

                <div
                    v-else
                    class="flex flex-col items-start justify-start space-y-5"
                >
                    <Badge variant="default" class="rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400 px-3 py-1 text-xs font-semibold">Activée</Badge>

                    <p class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed">
                        Avec la double authentification activée, vous serez invité à saisir un code de sécurité à chaque connexion.
                        Ce code est généré par l'application TOTP que vous avez configurée.
                    </p>

                    <TwoFactorRecoveryCodes />

                    <div class="relative inline">
                        <Form v-bind="disable.form()" #default="{ processing }">
                            <Button
                                variant="destructive"
                                type="submit"
                                :disabled="processing"
                                class="rounded-full px-6 py-2.5 font-semibold shadow-sm transition-all"
                            >
                                <ShieldBan class="mr-2 h-4 w-4" />
                                Désactiver la 2FA
                            </Button>
                        </Form>
                    </div>
                </div>

                <TwoFactorSetupModal
                    v-model:isOpen="showSetupModal"
                    :requiresConfirmation="requiresConfirmation"
                    :twoFactorEnabled="twoFactorEnabled"
                />
            </div>
        </SettingsLayout>
    </AppLayout>
</template>