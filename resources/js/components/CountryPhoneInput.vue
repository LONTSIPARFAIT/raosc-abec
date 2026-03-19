<script setup lang="ts">
import { ref, computed, watch, onMounted } from 'vue';

const props = defineProps<{
    modelValue: string;
    modelCountry?: string; // Code ISO 2 (ex: CM, BJ)
    placeholder?: string;
}>();

const emit = defineEmits(['update:modelValue', 'update:modelCountry']);

const searchQuery = ref('');
const isDropdownOpen = ref(false);
const showDropdownList = ref(false);

const currentNumber = ref(props.modelValue || '');
const currentCountryIso = ref(props.modelCountry || 'CM');

const countries = [
  { name: 'Cameroun', iso: 'CM', dial: '+237', flag: '🇨🇲' },
  { name: 'Bénin', iso: 'BJ', dial: '+229', flag: '🇧🇯' },
  { name: 'Sénégal', iso: 'SN', dial: '+221', flag: '🇸🇳' },
  { name: 'Togo', iso: 'TG', dial: '+228', flag: '🇹🇬' },
  { name: 'Côte d\'Ivoire', iso: 'CI', dial: '+225', flag: '🇨🇮' },
  { name: 'Mali', iso: 'ML', dial: '+223', flag: '🇲🇱' },
  { name: 'Burkina Faso', iso: 'BF', dial: '+226', flag: '🇧🇫' },
  { name: 'Niger', iso: 'NE', dial: '+227', flag: '🇳🇪' },
  { name: 'Guinée', iso: 'GN', dial: '+224', flag: '🇬🇳' },
  { name: 'Tchad', iso: 'TD', dial: '+235', flag: '🇹🇩' },
  { name: 'République du Congo', iso: 'CG', dial: '+242', flag: '🇨🇬' },
  { name: 'RDC', iso: 'CD', dial: '+243', flag: '🇨🇩' },
  { name: 'Gabon', iso: 'GA', dial: '+241', flag: '🇬🇦' },
  { name: 'RCA', iso: 'CF', dial: '+236', flag: '🇨🇫' },
  { name: 'Nigeria', iso: 'NG', dial: '+234', flag: '🇳🇬' },
  { name: 'Ghana', iso: 'GH', dial: '+233', flag: '🇬🇭' },
  { name: 'Maroc', iso: 'MA', dial: '+212', flag: '🇲🇦' },
  { name: 'Algérie', iso: 'DZ', dial: '+213', flag: '🇩🇿' },
  { name: 'Tunisie', iso: 'TN', dial: '+216', flag: '🇹🇳' },
  { name: 'Afrique du Sud', iso: 'ZA', dial: '+27', flag: '🇿🇦' },
  { name: 'France', iso: 'FR', dial: '+33', flag: '🇫🇷' },
];

const selectedCountry = computed(() => {
   return countries.find(c => c.iso === currentCountryIso.value) || countries[0];
});

const filteredCountries = computed(() => {
    if (!searchQuery.value) return countries;
    return countries.filter(c => 
        c.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
        c.dial.includes(searchQuery.value)
    );
});

// Auto-detect country based on dial code typed in the input
const autoDetectCountry = (val: string) => {
    // Check if the input starts with + and matches any dial code
    if (val.startsWith('+')) {
        // Sort dial codes by length descending so +2253 is checked for +225 before +22
        const sortedCountries = [...countries].sort((a,b) => b.dial.length - a.dial.length);
        const match = sortedCountries.find(c => val.startsWith(c.dial));
        if (match && match.iso !== currentCountryIso.value) {
            currentCountryIso.value = match.iso;
            emit('update:modelCountry', match.iso);
        }
    }
};

const handleInput = (e: Event) => {
    const val = (e.target as HTMLInputElement).value;
    currentNumber.value = val;
    autoDetectCountry(val);
    emit('update:modelValue', val);
};

const selectCountry = (country: any) => {
    currentCountryIso.value = country.iso;
    emit('update:modelCountry', country.iso);
    
    // Replace dial code if starting with another one, or just set it
    // if currentNumber doesn't have it.
    let numberPart = currentNumber.value;
    if (numberPart.startsWith('+')) {
        // Strip previous dial code based on current one if present
        const match = countries.sort((a,b) => b.dial.length - a.dial.length).find(c => numberPart.startsWith(c.dial));
        if (match) {
            numberPart = numberPart.substring(match.dial.length).trim();
        }
    }
    
    // Set formatted to start with new dial code
    currentNumber.value = `${country.dial} ${numberPart}`.trim();
    emit('update:modelValue', currentNumber.value);
    
    isDropdownOpen.value = false;
    showDropdownList.value = false;
};

// Close dropdown on outside click
onMounted(() => {
    document.addEventListener('click', (e) => {
        const target = e.target as HTMLElement;
        if (!target.closest('.country-phone-input')) {
            isDropdownOpen.value = false;
            showDropdownList.value = false;
        }
    });
});
</script>

<template>
    <div class="relative country-phone-input w-full">
        <div class="flex items-stretch bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-2xl overflow-visible focus-within:ring-2 focus-within:ring-raosc-green/20 focus-within:border-raosc-green transition-all relative">
            
            <button 
                type="button" 
                @click="isDropdownOpen = !isDropdownOpen; if(isDropdownOpen) showDropdownList = true; else showDropdownList = false"
                class="flex items-center justify-center gap-1.5 px-4 text-sm bg-transparent border-r border-zinc-200 dark:border-zinc-800 hover:bg-zinc-100 dark:hover:bg-zinc-900 transition-colors z-10 shrink-0 select-none"
            >
                <span class="text-xl leading-none">{{ selectedCountry.flag }}</span>
                <span class="text-zinc-500 font-bold text-[10px]">&nbsp;▼</span>
            </button>

            <!-- Dropdown -->
            <div 
                v-if="showDropdownList" 
                class="absolute left-0 top-full mt-2 w-[280px] bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-2xl z-50 overflow-hidden flex flex-col"
            >
                <div class="p-3 border-b border-zinc-100 dark:border-zinc-800">
                    <input 
                        v-model="searchQuery" 
                        type="text" 
                        placeholder="Chercher un pays..." 
                        class="w-full bg-zinc-50 dark:bg-zinc-950 border border-zinc-200 dark:border-zinc-800 rounded-xl px-4 py-2.5 text-xs outline-none focus:ring-1 focus:ring-raosc-green dark:text-white font-medium"
                        @click.stop
                    >
                </div>
                <div class="max-h-[250px] overflow-y-auto w-full no-scrollbar">
                    <div 
                        v-for="country in filteredCountries" 
                        :key="country.iso"
                        @click="selectCountry(country)"
                        class="flex flex-row items-center justify-between px-4 py-3 hover:bg-zinc-50 dark:hover:bg-zinc-800 cursor-pointer transition-colors"
                    >
                        <div class="flex items-center gap-3">
                            <span class="text-xl">{{ country.flag }}</span>
                            <span class="text-sm font-semibold text-zinc-900 dark:text-white tracking-tight">{{ country.name }}</span>
                        </div>
                        <span class="text-xs font-bold text-zinc-400">{{ country.dial }}</span>
                    </div>
                </div>
            </div>

            <input 
                :value="currentNumber"
                @input="handleInput"
                type="text" 
                :placeholder="placeholder || '+237 ...'" 
                class="w-full bg-transparent px-4 py-4 outline-none text-sm dark:text-white font-medium" 
            />
        </div>
    </div>
</template>

