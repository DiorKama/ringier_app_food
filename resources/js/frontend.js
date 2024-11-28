window.$ = window.jQuery = require('jquery');
window.Popper = require('popper.js').default;
require('bootstrap');



$(document).off('click', '.add-to-cart').on('click', '.add-to-cart', function(e) {
    e.preventDefault();
    
    var button = $(this);
    var menuItemId = button.data('id');
    console.log('ID du menuItem:', menuItemId); // Debug

    // Désactiver le bouton temporairement
    button.prop('disabled', true);

    $.ajax({
        url: '/user/order/add/' + menuItemId,
        method: 'POST',
        data: { 
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            console.log(response); // Debug réponse de l'API

            // Réactiver le bouton après succès
            button.prop('disabled', false);

            // Mettre à jour le badge du panier
            $('.badge-danger').text(response.cart_count);

            // Utiliser Toastr pour afficher une notification stylisée
            toastr.success(response.message, 'Succès', {
                closeButton: true,
                progressBar: true,
                timeOut: 3000, // 3 secondes avant la disparition
            });

            // Rafraîchir la page après un court délai de 2 secondes
            setTimeout(function() {
                window.location.reload();
            }, 2000);
        },
        error: function(xhr) {
            console.error('Erreur:', xhr.responseText); // Debug erreur
            
            // Réactiver le bouton en cas d'erreur
            button.prop('disabled', false);

            if (xhr.status === 400) {
                // Affichez un message d'erreur spécifique si l'heure de clôture est dépassée
                toastr.error(xhr.responseJSON.message, 'Erreur', {
                    closeButton: true,
                    progressBar: true
                });
            } else {
                toastr.error('Erreur lors de l\'ajout au panier: ' + xhr.responseText, 'Erreur', {
                    closeButton: true,
                    progressBar: true
                });
            }
        }
    });
});


$(document).ready(function() {
    $('.modal-body').on('submit', 'form', function(event) {
        event.preventDefault(); // Empêche le rechargement de la page

        // Récupère l'URL du formulaire avec l'ID déjà inclus
        var form = $(this);
        var url = form.attr('action');

        // Envoie de la requête AJAX
        $.ajax({
            url: url,
            type: 'DELETE',
            data: form.serialize(),
            success: function(response) {
                // Utiliser le message de succès renvoyé par la réponse JSON
                toastr.success(response.success);
                form.closest('li').remove(); // Supprime l'élément de la liste
            },
            error: function(xhr) {
                // Utiliser le message d'erreur de la réponse JSON
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    toastr.error(xhr.responseJSON.error);
                } else {
                    toastr.error('Une erreur est survenue lors de la suppression de l\'article.');
                }
            }
        });
    });
});




    $.ajax({
        url: '/user/cart/modal-content',
        method: 'GET',
        success: function(response) {
            console.log(response); // Inspecte la réponse du serveur
            $('#cartModal').find('.modal-body').load('/user/cart/modal-content');

        },
        error: function(xhr) {
            console.error('Erreur lors du rafraîchissement du panier:', xhr.responseText);
        }
    });

    $(document).ready(function() {
        // Appel AJAX pour récupérer les commandes utilisateur du jour
        $.ajax({
            url: '/user/orders/today', // Créez cette route pour retourner les commandes du jour
            method: 'GET',
            success: function(response) {
                var ordersContainer = $('#user-orders');
                ordersContainer.empty(); // Vider le conteneur avant d'injecter les nouvelles données
    
                if (response.orders.length > 0) {
                    // Parcourir les commandes et créer les cartes
                    response.orders.forEach(function(order) {
                        // Vérifiez si l'ordre a des items
                        if (order.items.length > 0) {
                            var card = `
                                <div class="col-md-4">
                                    <div class="card mb-3" style="border-radius: 25px;">
                                        <div class="card-body text-center">
                                            <img src="/userImage.jpg" class="rounded-circle mb-3" width="60" height="60" alt="avatar">
                                            <h5 class="card-title">${order.user.firstName} ${order.user.lastName}</h5>
                                            ${order.items.map(item => `
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <p class="font-weight-bold mb-1">${item.menuItems.items.restaurants.title}</p>
                                                        <p class="mb-1">${item.menuItems.items.title}</p>
                                                        
                                                        
                                                    </div>
                                                    <span class="badge badge-danger">${item.quantity}x</span>
                                                </div>
                                            `).join('')}
                                        </div>
                                    </div>
                                </div>
                            `;
                            ordersContainer.append(card);
                        }
                    });
                } 
    
                // Si aucune carte valide n'a été ajoutée, afficher un message
                if (ordersContainer.children().length === 0) {
                    ordersContainer.html('<p>Aucune commande pour aujourd\'hui.</p>');
                }
            },
            error: function(xhr) {
                console.error('Erreur lors du chargement des commandes:', xhr.responseText);
                $('#user-orders').html('<p>Erreur lors du chargement des commandes.</p>');
            }
        });
    });
    














