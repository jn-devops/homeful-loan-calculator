<template>
<div class="px-4 sm:px-6 lg:px-8">
    <div class="mt-2 flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-4 lg:px-2">
                <div class="sm:rounded-lg">
                    <table class="min-w-full border-none border-separate border-spacing-y-2">
                        <thead class="bg-gray-50">
                            <tr class="p-4">
                                <th scope="col" class="p-4 text-center text-sm font-semibold text-gray-900 whitespace-nowrap">
                                    <slot name="thead" />
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            <!-- <tr class="p-4 hover:outline hover:outline-blue-500/50 rounded-lg border">
                                <td scope="col" class="p-4 text-center text-sm font-semibold text-gray-900 whitespace-nowrap">
                                    <slot name="tbody" />
                                </td>
                            </tr> -->
                            <tr class="p-4 hover:outline hover:outline-blue-500/50 rounded-lg border">
                                <td scope="col" class="p-4 text-center text-sm font-semibold text-gray-900 whitespace-nowrap">
                                    <slot name="tbody" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


</template>
