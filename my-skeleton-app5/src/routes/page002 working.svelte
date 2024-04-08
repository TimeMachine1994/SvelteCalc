<script>
    import { writable } from 'svelte/store';

    const currentPage = writable(1);
    let livestreamAtFuneralHome = null;
    let selectedPackage = '';
    let additionalLocations = { secondAddress: false, thirdAddress: false };
    let livestreamDuration = 2; // Default duration
    const packagePrices = { 'Solo': 399, 'Anywhere': 499, 'Legacy': 799 };
    let masterPrice = 0;
    let urlFriendlyText = "your_loved_ones_name_here";

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


    // my functions
    
    function convertText(){
         urlFriendlyText = formData.lovedOnesName.replace(/\s+/g, '_');
         urlFriendlyText = urlFriendlyText.toLowerCase();
         return urlFriendlyText;
    }
</script>

{#if $currentPage === 1}

<div class="min-h-screen bg-gray-700 flex items-center justify-center">
<!-- calculator goes here -->
    <div class="bg-gray-800 border-2 border-gray-900 shadow-2xl rounded-lg">
        <!-- form goes here -->
        <form class="border-b-2 border-gray-900 ">
            <p class="bg-gray-800  col-span-4 text-white text-center">Your Loved One's Custom Link</p> <br> 
            <p class="bg-gray-800  col-span-4 text-white text-center">Tributestream.com/celebration_of_life_for_{urlFriendlyText}</p>
            
        </form>

        
        <!-- buttons go here --> 
            <div class="p-6 text-gray-800 grid grid-cols-4 gap-5 text-xl">
                <p class="bg-gray-800  col-span-4 text-white text-center">Loved One's Name</p>
                <input type="text" class="bg-gray-800 border-2 border-gray-900 shadow-2xl rounded-lg col-span-4 text-white" bind:value={formData.lovedOnesName} on:input={convertText} placeholder="Loved One's Name" />
                <p class="bg-gray-800  col-span-4 text-white text-center">Livestream Date</p>
                <input type="text" class="bg-gray-800 border-2 border-gray-900 shadow-2xl rounded-lg col-span-4" bind:value={formData.livestreamDate} placeholder="Livestream Date" />
                <p class="bg-gray-800  col-span-4 text-white text-center">Your Name</p>
                <input type="text" class="bg-gray-800 border-2 border-gray-900 shadow-2xl rounded-lg col-span-4" bind:value={formData.yourName} placeholder="Your Name" />
                <p class="bg-gray-800  col-span-4 text-white text-center">Email</p>
                <input type="text" class="bg-gray-800 border-2 border-gray-900 shadow-2xl rounded-lg col-span-4" bind:value={formData.email} placeholder="Email" />
                <p class="bg-gray-800  col-span-4 text-white text-center">Phone Number</p>
                <input type="text" class="bg-gray-800 border-2 border-gray-900 shadow-2xl rounded-lg col-span-4" bind:value={formData.phoneNumber} placeholder="Phone Number" />
                <p class="bg-gray-800  col-span-4 text-white text-center">Are we livestreaming at the funeral home?</p>
                <button class="col-span-2 bg-gray-500 hover:bg-gray-400 rounded-full p-5 text-white text-center" on:click={() => livestreamAtFuneralHome = true}>Yes</button>
                <button class="col-span-2 bg-gray-500 hover:bg-gray-400 rounded-full p-5 text-white text-center" on:click={() => livestreamAtFuneralHome = false}>No</button>
                <div class="col-span-3">
                </div>
                <button class="col-span-1 bg-gray-500 hover:bg-gray-400 rounded-full p-5 text-white text-center" on:click={() => currentPage.set(2)}>Next</button>
            </div>          
          </div>
</div>
{:else}
    <div class="min-h-screen bg-gray-700 flex items-center justify-center">

     <!-- calculator goes here -->
     <div class="bg-gray-800 border-2 border-gray-900 shadow-2xl rounded-lg grid grid-cols-4 gap-2">
        <!-- form goes here -->
        <div  class="col-span-2 bg-gray-800 border-2 border-gray-900 shadow-2xl rounded-lg ">
            <div class="flex flex-col items-center justify-center p-4">
            

                <div>
                    <div class="flex items-center justify-center ">
                        {#if livestreamAtFuneralHome !== false}
                            <button class=" bg-gray-500 hover:bg-gray-400 rounded-full p-5 text-white text-center" on:click={() => selectPackage('Solo')}>Solo</button>
                        {/if}
                        <button class=" bg-gray-500 hover:bg-gray-400 rounded-full p-5 text-white text-center" on:click={() => selectPackage('Anywhere')}>Anywhere</button>
                        <button class=" bg-gray-500 hover:bg-gray-400 rounded-full p-5 text-white text-center" on:click={() => selectPackage('Legacy')}>Legacy</button>
                    </div>
                    
                        <!-- Livestream Duration Slider -->
                        <label>
                            <div class="flex items-center justify-center">
                             Livestream Duration: {livestreamDuration} hours
                            </div>
                            <div class="flex items-center justify-center">
                             <input type="range" min="1" max="8" bind:value={livestreamDuration}>
                            </div>
                         </label>
                
                    <!-- New Yes/No Questions -->
                    <label>
                        
                        <input type="checkbox" bind:checked={additionalLocations.secondAddress}>
                       
                            Are we livestreaming at a second address?
                        
                    </label>
                
                    <label>
                        <input type="checkbox" bind:checked={additionalLocations.thirdAddress}>
                        Are we livestreaming at a third address?
                    </label>
                    {#if additionalLocations.secondAddress}
                    <input type="text" bind:value={formData.secondAddress} placeholder="Enter second address" />
                {/if}

                    {#if additionalLocations.thirdAddress}
                        <input type="text" bind:value={formData.thirdAddress} placeholder="Enter third address" />
                    {/if}
    
                </div>
            </div>
        </div>
        <!-- cart goes here -->
        <div class="col-span-2 bg-gray-800 border-2 border-gray-900 shadow-2xl rounded-lg">
            <div class="flex flex-col items-center justify-center p-4">
            

                <!-- Existing cart display -->
                <div class="flex items-center justify-center">
                    Your Loved One's Custom Link 
                </div>
                <div class="flex items-center justify-center">
                    Tributestream.com/celebration_of_life_for_{urlFriendlyText}
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="border px-2 text-right">Services</th>
                                <th class="border px-2 text-right">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border px-2 text-right">Base Price</td>
                                <td class="border px-2 text-right"> ${masterPrice}</td>
                            </tr>
                            {#each additionalCharges as charge}
                                <tr>
                                    <td class="border px-2 text-right">{charge.item}</td>
                                    <td class="border px-2 text-right">${charge.price}</td>
                                </tr>
                            {/each}
                                <tr>
                                    <td class="border px-2 text-right">Total Cost</td>
                                    <td class="border px-2 text-right">${totalCost}</td>
                                </tr>    
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Existing file input and submit button -->
        </div>
     </div>
    </div>
    
    


<!-- old code -->


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

            <p>Your Loved One's Custom Link:</p> {urlFriendlyText}

            <!-- Cart Table -->
            

			<p>Selected Package: {selectedPackage} - ${masterPrice}</p>
            {#each additionalCharges as charge}
                <p>{charge.item}: +${charge.price}</p>
            {/each}
            <p>Total Cost: ${totalCost}</p>
            <!-- Existing file input and submit button -->
        </div>
    </div>
{/if}
