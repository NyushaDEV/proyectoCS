var AirportsArrival = [];
$(function () {
  $.widget("custom.combobox", {
    _create: function () {
      this.wrapper = $("<span>")
        .addClass("custom-combobox")
        .insertAfter(this.element);

      this.element.hide();
      this._createAutocomplete();
      this._createShowAllButton();
    },

    _createAutocomplete: function () {
      var selected = this.element.children(":selected"),
        value = selected.val() ? selected.text() : "";
        console.log();

      this.input = $("<input>")
        .appendTo(this.wrapper)
        .val(value)
        .attr("id", "inpt_"+ this.element.attr('id'))
        .addClass("custom-combobox-input  ui-widget ui-widget-content ui-state-default ui-corner-left")
        .autocomplete({
          delay: 0,
          minLength: 0,
          source: $.proxy(this, "_source"),
          select: function () {
            $('#combobox_destino').empty("");
            let origen = $('#combobox_origen').val();
            // Cargar Aeropuertos de destino
            console.log(origen);

            $.ajax({
              type: 'POST',
              url: "ajax/ruta_destino.php",
              dataType: 'json',
              data: {
                origen: origen
              },
            }).done(function (data) {

              $.each(data, function (i, ele) {
                console.log(ele[0].nombre);
                $('#combobox_destino').append('<option value="'+ele[0].nombre+'">'+ele[0].nombre+'</option>')
              });

            }).fail(function (jqXHR, textStatus, msg) {
              console.log(msg);
            });

          }
        })
        .tooltip({
          classes: {
            "ui-tooltip": "ui-state-highlight"
          }
        });

      this._on(this.input, {
        autocompleteselect: function (event, ui) {
          ui.item.option.selected = true;
          this._trigger("select", event, {
            item: ui.item.option
          });
        },

        autocompletechange: "_removeIfInvalid"
      });
    },

    _createShowAllButton: function () {
      var input = this.input,
        wasOpen = false;

      $("<a>")
        .attr("tabIndex", -1)
        .attr("title", "Todos los aeropuertos")
        .tooltip()
        .appendTo(this.wrapper)
        .button({
          icons: {
            primary: "ui-icon-triangle-1-s"
          },
          text: false
        })
        .removeClass("ui-corner-all")
        .addClass("custom-combobox-toggle ui-corner-right")
        .on("mousedown", function () {
          wasOpen = input.autocomplete("widget").is(":visible");
        })
        .on("click", function () {
          input.trigger("focus");

          // Close if already visible
          if (wasOpen) {
            return;
          }

          // Pass empty string as value to search for, displaying all results
          input.autocomplete("search", "");
        });
    },

    _source: function (request, response) {
      var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
      response(this.element.children("option").map(function () {
        var text = $(this).text();
        if (this.value && (!request.term || matcher.test(text)))
          return {
            label: text,
            value: text,
            option: this
          };
      }));
    },

    _removeIfInvalid: function (event, ui) {

      // Selected an item, nothing to do
      if (ui.item) {
        return;
      }

      // Search for a match (case-insensitive)
      var value = this.input.val(),
        valueLowerCase = value.toLowerCase(),
        valid = false;
      this.element.children("option").each(function () {
        if ($(this).text().toLowerCase() === valueLowerCase) {
          this.selected = valid = true;
          return false;
        }
      });

      // Found a match, nothing to do
      if (valid) {
        return;
      }

      // Remove invalid value
      this.input
        .val("")
        .attr("title", "No se ha encontrado ningún aeropuerto.")
        .tooltip("open");
      this.element.val("");
      this._delay(function () {
        this.input.tooltip("close").attr("title", "");
      }, 2500);
      this.input.autocomplete("instance").term = "";
    },

    _destroy: function () {
      this.wrapper.remove();
      this.element.show();
    }
  });

  $("#combobox_origen").combobox();
  $("#combobox_destino").combobox();
  $("#toggle").on("click", function () {
    $("#combobox_origen").toggle();
  });
});