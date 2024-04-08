<script>
    import { writable } from 'svelte/store';

    const currentPage = writable(1);
    let livestreamAtFuneralHome = null;
    let selectedPackage = '';
    let additionalLocations = { secondAddress: false, thirdAddress: false };
    let livestreamDuration = 2; // Default duration
    const packagePrices = { 'Solo': 399, 'Anywhere': 499, 'Legacy': 799 };
    let masterPrice = 0;

    let formData = {
        lovedOnesName: '',
        livestreamDate: '',
        yourName: '',
        email: '',
        phoneNumber: '',
        secondAddress: '',
        thirdAddress: ''
    };

    $: if (selectedPackage === 'Solo' && (additionalLocations.secondAddress || additionalLocations.thirdAddress)) {
        selectPackage('Anywhere');
    }
	$: additionalCharge = (additionalLocations.secondAddress ? 399 : 0) + (additionalLocations.thirdAddress ? 329 : 0) + (livestreamDuration > 2 ? (livestreamDuration - 2) * 99 : 0);

	$: totalCost = masterPrice + additionalCharge;
	let additionalCharges = [];

	$: {
		additionalCharges = [];
		if (additionalLocations.secondAddress) {
			additionalCharges.push({ item: 'Location B', price: 399 });
		}
		if (additionalLocations.thirdAddress) {
			additionalCharges.push({ item: 'Location C', price: 329 });
		}
		if (livestreamDuration > 2) {
			let extraHours = livestreamDuration - 2;
			additionalCharges.push({ item: `Additional Livestream Time (${extraHours}h)`, price: extraHours * 99 });
		}
		totalCost = masterPrice + additionalCharges.reduce((sum, charge) => sum + charge.price, 0);
	}


    function selectPackage(packageName) {
        selectedPackage = packageName;
        masterPrice = packagePrices[packageName];
    }

    function submitForm() {
        // Logic to handle form submission
        // Send data to a Google spreadsheet
    }
</script>

{#if $currentPage === 1}
<div>
	<input type="text" bind:value={formData.lovedOnesName} placeholder="Loved One's Name" />
	<input type="text" bind:value={formData.livestreamDate} placeholder="Livestream Date" />
	<input type="text" bind:value={formData.yourName} placeholder="Your Name" />
	<input type="text" bind:value={formData.email} placeholder="Email" />
	<input type="text" bind:value={formData.phoneNumber} placeholder="Phone Number" />
	<button on:click={() => livestreamAtFuneralHome = true}>Yes</button>
	<button on:click={() => livestreamAtFuneralHome = false}>No</button>
	<p>Are we livestreaming at the funeral home?</p>
	<button on:click={() => currentPage.set(2)}>Next</button>
</div>
{:else}
    <div>
        <div>
			<div>
				{#if livestreamAtFuneralHome !== false}
					<button on:click={() => selectPackage('Solo')}>Solo</button>
				{/if}
				<button on:click={() => selectPackage('Anywhere')}>Anywhere</button>
				<button on:click={() => selectPackage('Legacy')}>Legacy</button>
			</div>
            <!-- New Yes/No Questions -->
            <label>
                <input type="checkbox" bind:checked={additionalLocations.secondAddress}>
                Are we livestreaming at a second address?
            </label>
            {#if additionalLocations.secondAddress}
                <input type="text" bind:value={formData.secondAddress} placeholder="Enter second address" />
            {/if}

            <label>
                <input type="checkbox" bind:checked={additionalLocations.thirdAddress}>
                Are we livestreaming at a third address?
            </label>
            {#if additionalLocations.thirdAddress}
                <input type="text" bind:value={formData.thirdAddress} placeholder="Enter third address" />
            {/if}

            <!-- Livestream Duration Slider -->
            <label>
                Livestream Duration: {livestreamDuration} hours
                <input type="range" min="1" max="8" bind:value={livestreamDuration}>
            </label>
        </div>
        <div>
            <!-- Existing cart display -->
			<p>Selected Package: {selectedPackage} - ${masterPrice}</p>
            {#each additionalCharges as charge}
                <p>{charge.item}: +${charge.price}</p>
            {/each}
            <p>Total Cost: ${totalCost}</p>
            <!-- Existing file input and submit button -->
        </div>
    </div>
{/if}
 