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


<!--
Chat GPT Prompt for code: Ok perfect, now let's spice things up a little bit. We are going to create a two page application with a cart display like we did in svlete, but with a ton of modifications.
Step one: the first page is going to have form questions for the following: Loves Ones Name (text field) Livestream Date (text field) Your Name (text field) Email (text field) Phone Number (text field) and a question with two buttons side by side, Yes, or No- the question is "Are we livestreaming at the funeralhome?"
Then there is a next button, which will load the "second page" of our SPA.
The next page should be devided in half with form questions on the left half and a dynamic master price and cart display centered on the right hand side.
Also on the right hand side above the master price is a Text with a modified display of the Loved Ones Name on page 1. To be more specific, the Text will read: "Your Loved Ones ustom Link <br> Tributestream.com/loved_ones_Name"
Under the dynamic cart should be a click to upload an image button that prompts for an upload, and be low that a "book now" button that sends all the data to a google spread sheet for further processing.
Now, I will specificy the breakdown of the forms on the left side. It should start with the text "Chose your Tributestream"
Based on the "Are we livestreaming atthe funeralhome?" question we will present either three or two button options side by side, "Solo" "Anywhere" or "Legacy", dropping the Solo if the answer to the question "Are we livestreaming at the funeralhome?" is "No".
Then, based on the users input, we will update the cart and master price on the right. 
The values are as follows: Solo, $399, Anywhere, $499, and Legacy $799. The master price should update with the just the price, and only one package can be selected. Further more, the cart should display both the name and price of the package.
This should be setup so we can add more questions below the packges with ease. 
Write this in svelte. 
---- Part 2
Great this works perfectly. Now I want you to create me a new prompt. Using the code we just discussed, I would like to add the following forms on the left hand part. 
Each of the following questions should be listed with a yes or no button side by side. If it prompts a change in price and addition to cart, I will specify.
"Are we livestreaming the viewing before the service?" If this is a yes, change the user's selection to Anywhere if it is Solo, and don't change it if is Anywhere or Legacy already.
"Are we livestreamming the committal outdoors?" If this is a yes, change the user's selection to Anywere if it is Solo, and don't change it if is Anywhere or Legacy already.
"Are we livestreaming at a second address?" If yes, add a "enter address" text box below. If no, remove it. If yes, add $399 to the master price. "Location B, +$399" for the cart.
"Are we livestreaming at a third address?" If yes, add a "enter address" text box below. If no, remove it. If yes, add $329 to the price. "Location C, +$329" for the cart.
Now display a slider with the text title, Livestream Duration. Below that should be a master hour's display, and below that the slider from 1-8. Each hour past (2) increase the price by $99. Display the cart Additional Livestream Time $99/h x "number of hours past 2"
-->