/**
 * Simple JS calls used on the settings page
 *
 * Licensed under Expat License
 * See LICENSE in the root of the source tree
 *
 * Copyright (c) Ferenc Szekely <ferenc.szekely@urho.eu>
 *
 */
jQuery(document).ready(function() {
  // handle + (adding a new key)
  jQuery('.keys .control.add').on('click', function(event)
  {
    // check if the last row of .keys is empty or not
    // add a new row if last row is not empty
    if (jQuery('.keys .key:last .col1 input').val() != '') {
      var index = new Number(jQuery('.keys .key:last').attr('data-index'));

      newRow = jQuery('.keys .key:last').clone(true);
      // blank all inputs
      newRow.find('input[type=text]').val('');
      // this makes it easier to adjust index of new rows
      newRow.attr('data-index', ++index);

      // make sure the index is correct for the key and comment inputs
      var oldName, newName;
      newRow.find("input[type='text']").each(function(idx) {
        oldName = jQuery(this).attr('name');
        newName = oldName.replace(/\[\d*\]/, '[' + index + ']');
        jQuery(this).attr('name', newName);
      });

      // change styling class for the new row
      if (newRow.hasClass('odd')) {
        newRow.removeClass('odd');
        newRow.addClass('even');
      } else {
        newRow.addClass('odd');
        newRow.removeClass('even');
      }

      // remove the + control from the current last row
      jQuery('.keys .key:last .control.add').remove();
      // append the new blank key row
      jQuery('.keys').append(newRow);
    }
  });

  // handle - (removing a key or the last blank key)
  jQuery('.keys .control.delete').on('click', function(event)
  {
    addRowSpan = false;
    // blank the input fields
    jQuery(event.target).parent().find('input[type=text]').val('');
    // if it was the last key clone the plus (add) element to the
    // 2nd but last line
    console.log(jQuery(event.target).parent().next('.key').length);

    // if more than 1 key exists => remove the line
    // check if the last row of .keys is empty or not
    // add a new row if last row is not empty
    if (jQuery('.keys .key').length > 1) {
      if (jQuery(event.target).parent().next('.key').length == 0) {
       // we were in the last row so clone the plus (add row) object
        addRowSpan = jQuery(event.target).parent().find('.control.add').clone(true);
      }
      jQuery(event.target).parent().remove();
      // add the + (add row) span to the last row
      if (addRowSpan !== false) {
        jQuery('.keys .key:last').find('.control.delete').before(addRowSpan);
      }
    }
  });
});
