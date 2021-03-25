/* -------------------------------------------------
Accordion BLock class to handle the opening/closing
of the accoridon blocks!
------------------------------------------------- */

export default class AccordionBlock {
  constructor(block, options = {}) {
    // The block is the whole AccordionBlock container
    this.block = block;
    // Here we can add some custom settings!
    this.settings = {
      class: 'js-accordion-block',
      duration: 500, //ms
    }

    // ObjectAssign all the user's options
    for (let key in this.settings) {
      // Just check if the key exists in the user's options and if it does override the defaults
      if (options[key]) this.settings[key] = options[key];
    }

    // Initialise the accordion block
    this.init();
  }

  init() {
    // This will store all the relevant elements for us
    this.elements = {};

    // Find the item elements. This will be found using this.settings.class followed by --item
    this.elements.items = this.block.querySelectorAll(`.${this.settings.class}--item`) || false;

    console.log(this.elements)

    // Ideally we want the elements in an array, not a nodeList
    this.items = [];

    // Loop the nodeList and push each element inside of an object to the items array
    for (let i = 0; i < this.elements.items.length; i++) this.items.push({
      item: this.elements.items[i],
      // Find the trigger element
      trigger: this.elements.items[i].querySelector(`.${this.settings.class}--trigger`) || false,
      // Find the target element
      target: this.elements.items[i].querySelector(`.${this.settings.class}--target`) || false,
      // We'll use this for the animations :)
      height: {
        current: 0,
        target: 0,
      }
    });

    // loop the items
    this.items.forEach((item) => {
    // If we have both a trigger and a target
      if (item.trigger && item.target) {
        // When we click the trigger
        item.trigger.addEventListener('click', (e) => {
          e.preventDefault();

          // Call the open function
          (item.item.classList.contains(`${this.settings.class}--open`)) ? this.close(item) : this.open(item);;
          this.open(item);
        });
      }
    });
  }

  tween(item = false) {
    console.log('here');
    if (item) {
      window.requestAnimationFrame(() => {
        if (item.height.current > item.height.target) {
        // If the item needs to close - shrink it's current height
          item.height.current -= Math.floor(item.height.target / (.6 * this.settings.duration / 60));
        }else if (item.height.current < item.height.target) {
          // If the item needs to open - grow it's current height
          item.height.current += Math.floor(item.height.target / (this.settings.duration / 60));
        }else {
          // Otherwise end the function!
          return;
        }

        // console.log(item);

        // Set the height on the element.
        item.target.style.height = item.height.current + 'px';

        // Repeat the function
        this.tween(item);
      });
    }
  }

  open(item) {
    // Toggle some classes for css usage
    item.item.classList.add(`${this.settings.class}--open`);
    item.item.classList.remove(`${this.settings.class}--closed`);

    // Set the item's current height to it's current height ¯\_(ツ)_/¯
    item.height.current = item.target.clientHeight;

    // Start by setting the target's height to auto!
    item.target.style.height = 'auto';

    // Save the target's height
    item.height.target = item.target.clientHeight;

    // Set the target's height to back to it's initial state fast!
    item.target.style.height = item.height.current + 'px';

    // Now we need to animate this change
    this.tween(item);
  }

  // close(item) {
  //   // Toggle some classes for css usage
  //   item.item.classList.add(`${this.settings.class}--closed`);
  //   item.item.classList.remove(`${this.settings.class}--open`);

  //   // Set the item's current height to it's current height ¯\_(ツ)_/¯
  //   item.height.current = item.target.clientHeight;

  //   // Start by setting the target's height to auto!
  //   item.target.style.height = 0;

  //   // Save the target's height
  //   item.height.target = item.target.clientHeight;

  //   // Set the target's height to back to it's initial state fast!
  //   item.target.style.height = item.height.current + 'px';

  //   // Now we need to animate this change
  //   this.tween(item);
  // }
}