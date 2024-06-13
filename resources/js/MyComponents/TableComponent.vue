<template>
 <div class="px-4 sm:px-6 lg:px-8">
          <div class="mt-2 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
              <div class="inline-block min-w-full py-2 align-middle sm:px-4 lg:px-2">
                <div class="sm:rounded-lg">
                  <table class="min-w-full border-none border-separate border-spacing-y-2">
                    <thead class="bg-gray-50">
                      <tr class="p-4">
                        
                        <th scope="col" class="p-4 text-center text-sm font-semibold text-gray-900">
                            <slot name="thead" />
                        </th>
                        <!-- <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                          <span class="sr-only">Edit</span>
                        </th> -->
                      </tr>
                    </thead>
                    <tbody class=" bg-white">
                      <tr 
                      class="text-center hover:outline hover:outline-blue-500/50 rounded-lg border">
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900 w-1/5"> 
                            <slot name="tbody" />
                        </td>
                        <!-- <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                          <a href="#" class="text-indigo-600 hover:text-indigo-900"
                            >Edit<span class="sr-only"></span></a
                          >
                        </td> -->
                      </tr>
                      <!-- <tr class="text-center font-bold">
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900 border-l-2">{{ contact.profile.first_name }} {{ contact.profile.last_name }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900 border-l-2">8%</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900 border-l-2">₱ 207,142.86</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900 border-l-2">₱ 20,714.2</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900 border-l-2">₱ 186,428.57</td>
                      </tr> -->
                    </tbody>
                  </table>
                
                </div>
                
              </div>
            </div>
          </div>
        </div>
</template>
