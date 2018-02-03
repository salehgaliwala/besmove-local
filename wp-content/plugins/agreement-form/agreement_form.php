<?php
/*
* Plugin Name: Agreement Form
* Description: Add Tenants agreement
* Version: 1.0
*/


function form_creation(){
	?>
    <!-- MultiStep Form -->
    <div class="container">
    <div class="row tenancy-form">
        <div class="col-md-12 col-xs-12 col-md-offset-3">
            <form id="msform">

                <!-- progressbar -->
                <div class="col-md-9 col-xs-12">
                <div class="row">
                <ul id="progressbar">
                    <!--    <li class="active">The Parties</li>
                        <li>OTHER OCCUPIERS</li>
                        <li>THE PROPERTY AND COMMON PARTS</li>
                        <li>THE TERM AND EXPIRY OF THE FIXED TERM</li>
                        <li>THE RENT</li>
                        <li>COUNCIL TAX, UTILITIES AND OTHER CHARGES FOR SERVICES INCLUDED IN THE RENT</li>
                        <li>PAYMENT OF THE RENT BY THE TENANT</li>
                        <li>THE DEPOSIT</li>-->
                    <li class="active"></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                </ul>
                </div>
                </div>
                <!-- fieldsets -->
                <div class="col-md-9 col-xs-12">
                    <div class="row box-item">
                        <div class="col-md-4">
                            <img class="img-max-h" style="float: left" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAC0AAAAtCAYAAAA6GuKaAAAABGdBTUEAALGOfPtRkwAAACBjSFJNAACHDwAAjA8AAP1SAACBQAAAfXkAAOmLAAA85QAAGcxzPIV3AAAKOWlDQ1BQaG90b3Nob3AgSUNDIHByb2ZpbGUAAEjHnZZ3VFTXFofPvXd6oc0wAlKG3rvAANJ7k15FYZgZYCgDDjM0sSGiAhFFRJoiSFDEgNFQJFZEsRAUVLAHJAgoMRhFVCxvRtaLrqy89/Ly++Osb+2z97n77L3PWhcAkqcvl5cGSwGQyhPwgzyc6RGRUXTsAIABHmCAKQBMVka6X7B7CBDJy82FniFyAl8EAfB6WLwCcNPQM4BOB/+fpFnpfIHomAARm7M5GSwRF4g4JUuQLrbPipgalyxmGCVmvihBEcuJOWGRDT77LLKjmNmpPLaIxTmns1PZYu4V8bZMIUfEiK+ICzO5nCwR3xKxRoowlSviN+LYVA4zAwAUSWwXcFiJIjYRMYkfEuQi4uUA4EgJX3HcVyzgZAvEl3JJS8/hcxMSBXQdli7d1NqaQffkZKVwBALDACYrmcln013SUtOZvBwAFu/8WTLi2tJFRbY0tba0NDQzMv2qUP91829K3NtFehn4uWcQrf+L7a/80hoAYMyJarPziy2uCoDOLQDI3fti0zgAgKSobx3Xv7oPTTwviQJBuo2xcVZWlhGXwzISF/QP/U+Hv6GvvmckPu6P8tBdOfFMYYqALq4bKy0lTcinZ6QzWRy64Z+H+B8H/nUeBkGceA6fwxNFhImmjMtLELWbx+YKuGk8Opf3n5r4D8P+pMW5FonS+BFQY4yA1HUqQH7tBygKESDR+8Vd/6NvvvgwIH554SqTi3P/7zf9Z8Gl4iWDm/A5ziUohM4S8jMX98TPEqABAUgCKpAHykAd6ABDYAasgC1wBG7AG/iDEBAJVgMWSASpgA+yQB7YBApBMdgJ9oBqUAcaQTNoBcdBJzgFzoNL4Bq4AW6D+2AUTIBnYBa8BgsQBGEhMkSB5CEVSBPSh8wgBmQPuUG+UBAUCcVCCRAPEkJ50GaoGCqDqqF6qBn6HjoJnYeuQIPQXWgMmoZ+h97BCEyCqbASrAUbwwzYCfaBQ+BVcAK8Bs6FC+AdcCXcAB+FO+Dz8DX4NjwKP4PnEIAQERqiihgiDMQF8UeikHiEj6xHipAKpAFpRbqRPuQmMorMIG9RGBQFRUcZomxRnqhQFAu1BrUeVYKqRh1GdaB6UTdRY6hZ1Ec0Ga2I1kfboL3QEegEdBa6EF2BbkK3oy+ib6Mn0K8xGAwNo42xwnhiIjFJmLWYEsw+TBvmHGYQM46Zw2Kx8lh9rB3WH8vECrCF2CrsUexZ7BB2AvsGR8Sp4Mxw7rgoHA+Xj6vAHcGdwQ3hJnELeCm8Jt4G749n43PwpfhGfDf+On4Cv0CQJmgT7AghhCTCJkIloZVwkfCA8JJIJKoRrYmBRC5xI7GSeIx4mThGfEuSIemRXEjRJCFpB+kQ6RzpLuklmUzWIjuSo8gC8g5yM/kC+RH5jQRFwkjCS4ItsUGiRqJDYkjiuSReUlPSSXK1ZK5kheQJyeuSM1J4KS0pFymm1HqpGqmTUiNSc9IUaVNpf+lU6RLpI9JXpKdksDJaMm4ybJkCmYMyF2TGKQhFneJCYVE2UxopFykTVAxVm+pFTaIWU7+jDlBnZWVkl8mGyWbL1sielh2lITQtmhcthVZKO04bpr1borTEaQlnyfYlrUuGlszLLZVzlOPIFcm1yd2WeydPl3eTT5bfJd8p/1ABpaCnEKiQpbBf4aLCzFLqUtulrKVFS48vvacIK+opBimuVTyo2K84p6Ss5KGUrlSldEFpRpmm7KicpFyufEZ5WoWiYq/CVSlXOavylC5Ld6Kn0CvpvfRZVUVVT1Whar3qgOqCmrZaqFq+WpvaQ3WCOkM9Xr1cvUd9VkNFw08jT6NF454mXpOhmai5V7NPc15LWytca6tWp9aUtpy2l3audov2Ax2yjoPOGp0GnVu6GF2GbrLuPt0berCehV6iXo3edX1Y31Kfq79Pf9AAbWBtwDNoMBgxJBk6GWYathiOGdGMfI3yjTqNnhtrGEcZ7zLuM/5oYmGSYtJoct9UxtTbNN+02/R3Mz0zllmN2S1zsrm7+QbzLvMXy/SXcZbtX3bHgmLhZ7HVosfig6WVJd+y1XLaSsMq1qrWaoRBZQQwShiXrdHWztYbrE9Zv7WxtBHYHLf5zdbQNtn2iO3Ucu3lnOWNy8ft1OyYdvV2o/Z0+1j7A/ajDqoOTIcGh8eO6o5sxybHSSddpySno07PnU2c+c7tzvMuNi7rXM65Iq4erkWuA24ybqFu1W6P3NXcE9xb3Gc9LDzWepzzRHv6eO7yHPFS8mJ5NXvNelt5r/Pu9SH5BPtU+zz21fPl+3b7wX7efrv9HqzQXMFb0ekP/L38d/s/DNAOWBPwYyAmMCCwJvBJkGlQXlBfMCU4JvhI8OsQ55DSkPuhOqHC0J4wybDosOaw+XDX8LLw0QjjiHUR1yIVIrmRXVHYqLCopqi5lW4r96yciLaILoweXqW9KnvVldUKq1NWn46RjGHGnIhFx4bHHol9z/RnNjDn4rziauNmWS6svaxnbEd2OXuaY8cp40zG28WXxU8l2CXsTphOdEisSJzhunCruS+SPJPqkuaT/ZMPJX9KCU9pS8Wlxqae5Mnwknm9acpp2WmD6frphemja2zW7Fkzy/fhN2VAGasyugRU0c9Uv1BHuEU4lmmfWZP5Jiss60S2dDYvuz9HL2d7zmSue+63a1FrWWt78lTzNuWNrXNaV78eWh+3vmeD+oaCDRMbPTYe3kTYlLzpp3yT/LL8V5vDN3cXKBVsLBjf4rGlpVCikF84stV2a9021DbutoHt5turtn8sYhddLTYprih+X8IqufqN6TeV33zaEb9joNSydP9OzE7ezuFdDrsOl0mX5ZaN7/bb3VFOLy8qf7UnZs+VimUVdXsJe4V7Ryt9K7uqNKp2Vr2vTqy+XeNc01arWLu9dn4fe9/Qfsf9rXVKdcV17w5wD9yp96jvaNBqqDiIOZh58EljWGPft4xvm5sUmoqbPhziHRo9HHS4t9mqufmI4pHSFrhF2DJ9NProje9cv+tqNWytb6O1FR8Dx4THnn4f+/3wcZ/jPScYJ1p/0Pyhtp3SXtQBdeR0zHYmdo52RXYNnvQ+2dNt293+o9GPh06pnqo5LXu69AzhTMGZT2dzz86dSz83cz7h/HhPTM/9CxEXbvUG9g5c9Ll4+ZL7pQt9Tn1nL9tdPnXF5srJq4yrndcsr3X0W/S3/2TxU/uA5UDHdavrXTesb3QPLh88M+QwdP6m681Lt7xuXbu94vbgcOjwnZHokdE77DtTd1PuvriXeW/h/sYH6AdFD6UeVjxSfNTws+7PbaOWo6fHXMf6Hwc/vj/OGn/2S8Yv7ycKnpCfVEyqTDZPmU2dmnafvvF05dOJZ+nPFmYKf5X+tfa5zvMffnP8rX82YnbiBf/Fp99LXsq/PPRq2aueuYC5R69TXy/MF72Rf3P4LeNt37vwd5MLWe+x7ys/6H7o/ujz8cGn1E+f/gUDmPP8usTo0wAAAAlwSFlzAAAOxAAADsQBlSsOGwAABFdJREFUaEPtmQuT2jYQx/9gY2NsAwcJN22neUzafv/P08ekTS5tQi48DowfGKj+MnKActSWro+byTLMcNzu6qf1rqQVjfn0/Q6PTJqPjFfifoH+t57ao4x046EK8W65wHQ6QRwnaDaLWGy3W3heG1dXA3SD8MEehDF0FEf48McYUbJCIoA3280RnNW00BbgfruD669G8D3fGN4ImtH97Zc3iLIIlm3BbtpngfJtjk2+ge/4eP7qmXHUtXM6WkV4/fpXCew6bgnMlFCiPnMy1KGutBG2JqINffv+VqREAYzPnGU+y/V0n9tFgqMAFza0NREtaKYFc7jVbMliq7Tai5GoSxva0oeuaEFHiyWidCUjeRTNv6FQ+rSlD13Rg45XWKfrWsAKkOC0jYQPXdGCbloiwuJ9WHRVAWij7KvanOppQW83ReXVSY3DSMu63PvQAa8Nna5T5FmuM9aRDX3Ql47Uhr5587usfNuysdvttN60pQ/60pHa0Ok6QZ7nsCwLjUZD601b+qAvHakNLXNZFKHMy4Pdr+rgykb5qGp3qFcb+np0DR6CGCkWYh1wuXIIG/mkhA/60pHa0MPBAC9fPIdt2yV41YEVMG3pg750pDY0B3kyfIJvv/4Gju3ISFeJttKjDW3pQ1e0oDlY96qLfr+LNE0rrdeMMnVpQ1sT0YZmxIIwRKtVHJouRVv9n7q0oa2JaENz0DAMMBSt1Dq/fA6R5w2hQ90gNO9cjKCdloPh0yFc2y2jLWJeBpGfVZSpI3Vb4vxtKEbQHLsXdvHi5TMJJ4+eB4dr+dd+WaQOdR9CjHpEnh1Wi5WI5w52y8ZsMsXtZFLmN9uswaCP/uAK6yzDNt8h7Ifw3LYRe2XofJfDbtjI1hniJMGnj58QRQKYRSherisK0wsQ9gJZnJRE6M2mc2R5JlaOTH7HyPteR67RnbCjlS6VodmMTqczLEXHkQpwntIIe7grOo4j4VVXzp0vTouzCrOG6VI2u2KD4Z1I4Afo9sQyWONe5CJ0HMeyc76bL5BkiYysrDMBwF3tVFTRqbsPbtX3tWRyIntR9yLdXgi/44vJeBfT5yz0bD7HcrnEMhK9oADlpsBH/hfQ/QRUEV4aSemc0+W9CFsw13Xh+x0Z/SAI0O/1zro8go6TGOMPY0xmM6RxCqslImUfrwiMtEoLk2o6By+rI99is97A9VwM+n2Mrkfw2seRL5c8Ftjbmxu8ffeuKCxhxMge5mFRSXpt1ukET1s1OQnx4pgcmwxkIRPZDqWEnojlar64E4/HL9baey5gTKJ7yfb0YocMZCET2c5Cr8QFCnO3FONtx2B6B2OTiWxnoS3uZprXAgZ4F03VdQPZzkKrL3WuBf4p6PtY/ssk0J7rF2jt0NU0fPyRVufhYg/8n7xOVg4+lHIb//HnnzAef6zUpNZ8mkbqXPZGo6f44bvvSz8l9F0kTnLi/Gs1LKNBHtp4s9ug3W6j63/+Se9P83VOvwmelh4AAAAASUVORK5CYII="
                                 alt="" >
                            <h5 style="float: left; padding-left: 0.5em;">Tenant</h5>
                        </div>
                        <div class="col-md-4">

                        </div>
                        <div class="col-md-4">

                            <img class="img-max-h" style="float: right;" src="data:image/png;base64,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"
                            alt="" >
                            <h5 style="float: right; padding-right: 0.5em;">Landlord</h5>
                        </div>
                    </div>
                    <div class="row">
                        <fieldset>
                            <h2 class="fs-title">User Details</h2>
                            <!--                            <h3 class="fs-subtitle">Tell us something more about you</h3>-->
                            <label>Name</label>
                            <input type="text" name="fname" placeholder=""/>
                            <label>Email</label>
                            <input type="text" name="lname" placeholder=""/>
                            <label>Phone Number</label>
                            <input type="text" name="lname" placeholder=""/>

                            <input type="button" name="next" class="next action-button" value="Next"/>
                        </fieldset>

                        <fieldset>
                            <h2 class="fs-title">The Parties</h2>
<!--                            <h3 class="fs-subtitle">Tell us something more about you</h3>-->
                            <label>Name of Landlord</label>
                            <input type="text" name="fname" placeholder=""/>
                            <h5>Name of Tenants</h5>
                            <label>Tenant 1</label>
                            <input type="text" name="lname" placeholder=""/>
                            <label>Tenant 2</label>
                            <input type="text" name="lname" placeholder=""/>
                            <label>Tenant 3</label>
                            <input type="text" name="lname" placeholder=""/>
                            <label>Other Tenants</label>
                            <input type="text" name="lname" placeholder=""/>

                            <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                            <input type="button" name="next" class="next action-button" value="Next"/>
                        </fieldset>
                        <fieldset>
                            <h2 class="fs-title">OTHER OCCUPIERS</h2>
                            <label>Adult 1 Name</label>
                            <input type="text" name="twitter" placeholder=""/>
                            <label>Adult 2 Name</label>
                            <input type="text" name="facebook" placeholder=""/>
                            <div class="row col-md-12" style="margin-bottom: 10px;">
                            <label>Tenant must ensure that not more than</label>
                            </div>
                            <div class="row col-md-12">
                                <select  name="gplus" class="col-md-4 col-xs-12">
                                    <option value="" selected disabled>Select a number</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                </select>
                            </div>
                            <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                            <input type="button" name="next" class="next action-button" value="Next"/>
                        </fieldset>

                        <fieldset>
                            <h2 class="fs-title">THE PROPERTY AND COMMON PARTS</h2>
                            <div class="row" style="margin-left: 0px;">
                            <label>The Property is : </label>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-xs-6">
                                <label class="">Fully furnished</label>
                                </div>
                                <div class="col-md-3 col-xs-2">
                                <input type="radio" name="furnished">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-xs-6">
                                <label class="">Part furnished</label>
                                </div>
                                <div class="col-md-3 col-xs-2">
                                <input type="radio" name="furnished">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-xs-6" >
                                <label class="">Unfurnished</label>
                                </div>
                                <div class="col-md-3 col-xs-2">
                                <input type="radio" name="furnished">
                                </div>
                            </div>

                            <hr/>

                            <div class="row" style="margin-left: 0px;">
                                <label>The Property is : </label>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-xs-6">
                                    <label class="">Private garden</label>
                                </div>
                                <div class="col-md-3 col-xs-2">
                                    <input type="checkbox" class="detail-textarea" name="private-garden">
                                </div>
                            </div>
                            <textarea placeholder="Private garden Details" hidden name="private-garden-details"></textarea>
                            <div class="row">
                                <div class="col-md-3 col-xs-6">
                                    <label class="">Garage</label>
                                </div>
                                <div class="col-md-3 col-xs-2">
                                    <input type="checkbox" class="detail-textarea" name="garage">
                                </div>
                            </div>
                            <textarea placeholder="Garage Details" hidden name="garage-details"></textarea>

                            <div class="row">
                                <div class="col-md-3 col-xs-6">
                                    <label class="">Other</label>
                                </div>
                                <div class="col-md-3 col-xs-2">
                                    <input type="checkbox" class="detail-textarea" name="other">
                                </div>
                            </div>
                            <textarea placeholder="Other Details" hidden name="other-details"></textarea>

                            <hr/>

                            <div class="row" style="margin-left: 0px;">
                                <label>Use of the following Common Parts : </label>
                            </div>

                            <div class="row">
                                <div class="col-md-4 col-xs-10">
                                    <label class="">Shared access to the Property</label>
                                </div>
                                <div class="col-md-3 col-xs-2">
                                    <input type="checkbox" class="detail-textarea" name="shared-access-property">
                                </div>
                            </div>
                            <textarea placeholder="Shared access to the Property Details" hidden name="shared-access-property-details"></textarea>

                            <div class="row">
                                <div class="col-md-4 col-xs-10">
                                    <label class="">Shared garden which is shared with</label>
                                </div>
                                <div class="col-md-3 col-xs-2">
                                    <input type="checkbox" class="detail-textarea" name="shared-access-garden">
                                </div>
                            </div>
                            <textarea placeholder="Shared garden which is shared with Details" hidden name="shared-access-garden-details"></textarea>

                            <div class="row">
                                <div class="col-md-4 col-xs-10">
                                    <label class="">Other shared facilities</label>
                                </div>
                                <div class="col-md-3 col-xs-2">
                                    <input type="checkbox" class="detail-textarea" name="other-shared-facilities">
                                </div>
                            </div>
                            <textarea placeholder="Other shared facilities Details" hidden name="other-shared-facilities-details"></textarea>

                            <div class="row">
                                <div class="col-md-5 col-xs-10">
                                    <label class="margin-fix">The Property currently subject to a mortgage</label>
                                </div>
                                <div class="col-md-3 col-xs-2">
                                    <input type="checkbox" name="property-mortgage">
                                </div>
                            </div>

                            <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                            <input type="button" name="next" class="next action-button" value="Next"/>
                        </fieldset>

                        <fieldset>
                            <h2 class="fs-title">THE TERM AND EXPIRY OF THE FIXED TERM</h2>
                            <div class="row">
                                <label>TENANCY DATE :</label>
                            </div>
                            <label>START</label>
                            <input type="date" name="fname" placeholder=""/>
                            <label>END</label>
                            <input type="date" name="fname" placeholder=""/>

                            <hr/>
                            <h2 class="fs-title">THE RENT</h2>
                            <label>Rent</label>
                            <input type="text" name="" placeholder="Price"/>

                            <label>Percentage for Rate Increase by landlord</label>
                            <input type="text" name="" placeholder="Percentage"/>

                            <div class="row col-md-12">
                            <label style="margin-top: 15px;">Agreed rent payment date</label>
                            </div>
                            <div class="row">
                                <div class="col-md-5 col-xs-10">
                                    <label class="">Per Week (Monday of each week)</label>
                                </div>
                                <div class="col-md-3 col-xs-2">
                                    <input type="radio" name="rent-type">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 col-xs-10">
                                    <label class="">Per Month (1st day of each month)</label>
                                </div>
                                <div class="col-md-3 col-xs-2">
                                    <input type="radio" name="rent-type">
                                </div>
                            </div>

                            <label>Date of First Payment</label>
                            <input type="date" name=""/>

                            <div class="row col-md-12">
                                <label>Method of payment</label>
                            </div>
                            <div class="row col-md-12">
                                <select  name="gplus" class="col-md-4 col-xs-12">
                                    <option value="" selected disabled>Select a payment method</option>
                                    <option value="1">Standing Order</option>
                                    <option value="2">Direct Debit</option>
                                    <option value="3">Cheque</option>
                                    <option value="4">Cash</option>
                                </select>
                            </div>

                            <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                            <input type="button" name="next" class="next action-button" value="Next"/>
                        </fieldset>

                        <fieldset>
                            <h2 class="fs-title">COUNCIL TAX, UTILITIES AND OTHER CHARGES FOR SERVICES INCLUDED IN THE RENT</h2>
                            <label>The following charges are included in and payable as part of the rent (check the boxes which apply ):</label>
                            <br/>
                            <div class="row">
                                <div class="col-md-4 col-xs-8">
                                    <label class="">Council Tax</label>
                                </div>
                                <div class="col-md-3 col-xs-2">
                                    <input type="checkbox"  name="council-tax">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 col-xs-8">
                                    <label class="">Water and sewerage charges</label>
                                </div>
                                <div class="col-md-3 col-xs-2">
                                    <input type="checkbox"  name="water-sewage-charges">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 col-xs-8">
                                    <label class="">Gas</label>
                                </div>
                                <div class="col-md-3 col-xs-2">
                                    <input type="checkbox"  name="gas">
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-4 col-xs-8">
                                    <label class="">Electricity</label>
                                </div>
                                <div class="col-md-3 col-xs-2">
                                    <input type="checkbox"  name="electricity">
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-4 col-xs-8">
                                    <label class="">Television licence fee</label>
                                </div>
                                <div class="col-md-3 col-xs-2">
                                    <input type="checkbox"  name="television-fee">
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-4 col-xs-8">
                                    <label class="">Telephone line rental</label>
                                </div>
                                <div class="col-md-3 col-xs-2">
                                    <input type="checkbox"  name="telephone-rental">
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-4 col-xs-8">
                                    <label class="">Broadband</label>
                                </div>
                                <div class="col-md-3 col-xs-2">
                                    <input type="checkbox"  name="broadband">
                                </div>
                            </div>

                                    <label class="">Other charges included:  (please state)</label>
                                    <textarea placeholder="Other charges included" name="other-charges"></textarea>

                            <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                            <input type="button" name="next" class="next action-button" value="Next"/>
                        </fieldset>
                        <fieldset>
                            <h2 class="fs-title">THE LANDLORD’S OR AGENT’S CONTACT DETAILS AND SERVICE OF NOTICES ON THE LANDLORD</h2>
                            <label>Landlord’s agent’s address</label>
                            <textarea name="" placeholder=""></textarea>

                            <hr/>
                            <div class="row">
                            <label>Q. Any notices given under or in connection with this agreement w
                                required to be given in writing may, alternatively, be sent by email.</label>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-xs-8">
                                    <label class="">Landlord agree</label>
                                </div>
                                <div class="col-md-3 col-xs-2">
                                    <input type="radio"  name="television-fee">
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-4 col-xs-8">
                                    <label class="">Landlord doesn’t agree</label>
                                </div>
                                <div class="col-md-3 col-xs-2">
                                    <input type="radio"  name="telephone-rental">
                                </div>
                            </div>
                            <hr/>

                            <div class="row col-md-12">
                            <label>Q.If landlord wishes to agree to service by email</label>
                            </div>
                            <label class="">Landlord Email</label>
                            <input type="text" name="" placeholder=""></input>

                            <label class="">Agent email</label>
                            <input type="text" name="" placeholder=""></input>
                            <hr/>

                            <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                            <input type="button" name="next" class="next action-button" value="Next"/>

                        </fieldset>

                        <fieldset>
                            <h2 class="fs-title">THE TENANT’S CONTACT DETAILS AND SERVICE OF NOTICES ON THE TENANT</h2>
                            <label>Service of written notices by email</label>
                            <div class="row">
                            <label>Q. Any notices given under or in connection with this agreement w
                                required to be given in writing may, alternatively, be sent by email.</label>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-xs-8">
                                    <label class="">Tenant Agree</label>
                                </div>
                                <div class="col-md-3 col-xs-2">
                                    <input type="radio"  name="television-fee">
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-4 col-xs-8">
                                    <label class="">Tenant Doesn’t agree</label>
                                </div>
                                <div class="col-md-3 col-xs-2">
                                    <input type="radio"  name="telephone-rental">
                                </div>
                            </div>
                            <hr/>

                            <div class="row col-md-12">
                            <label>Q.If Tenant wishes to agree to service by email</label>
                            </div>
                            <label class="">Tenant Email</label>
                            <input type="text" name="" placeholder=""></input>

                            <label class="">Tenant’s Emergency contact details</label>
                            <input type="text" name="" placeholder="Phone Number"></input>
                            <hr/>

                            <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                            <input type="submit" name="submit" class="submit action-button" value="Submit"/>
                        </fieldset>
                    </div>
                </div>
            </form>

        </div>
    </div>
    </div>
    <!-- /.MultiStep Form -->
	<?php wp_enqueue_style('agreement-form-style');?>
	<?php wp_enqueue_style('bootstrap-3-3');?>
	<?php wp_enqueue_script('agreement-form-script');?>
	<?php wp_enqueue_script('jquery-easing');?>
	<?php
}

add_shortcode('tenant_form2', 'form_creation');

add_action('wp_enqueue_scripts', 'agreement_form_scripts');
function agreement_form_scripts() {
	wp_register_style( 'agreement-form-style', plugins_url('style.css',__FILE__ ) );
	wp_register_script( 'agreement-form-script', plugins_url('tenancy-form.js' , __FILE__ ), array( 'jquery' ));
	wp_register_script( 'jquery-easing', plugins_url('jquery.easing.min.js' , __FILE__ ), array( 'jquery' ));

	wp_register_style( 'bootstrap-3-3', plugins_url('bootstrap.css',__FILE__ ) );
}

?>