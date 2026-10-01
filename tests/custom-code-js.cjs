// Isolated tests: never load a pixel or send network requests.
const {readFileSync} = require('node:fs');
const vm = require('node:vm');
const assert = require('node:assert/strict');
const source = readFileSync(require('node:path').join(__dirname, '../js/index.js'), 'utf8').split('// Consolidated plugin Purchase snippets:')[1];
assert.ok(source, 'purchase code exists');
const code = '// Consolidated plugin Purchase snippets:' + source;
const purchase = {eventId:'test-order',value:1275.50,currency:'INR'};
function run(data, options={}) {
  const calls=[], timers=[], listeners=[];
  const storage=options.storage || new Map();
  const window={playarenaPurchase:data, setTimeout:fn=>timers.push(fn),localStorage:{
    getItem:k=>{if(options.storageDenied) throw Error(); return storage.get(k);},
    setItem:(k,v)=>{if(options.storageDenied) throw Error(); storage.set(k,v);}
  }};
  if(!options.noPixel) window.fbq=(...args)=>calls.push(args);
  const context=vm.createContext({window,document:{readyState:options.loading?'loading':'complete',addEventListener:(event,fn)=>listeners.push(fn)}});
  vm.runInContext(code,context);
  return {calls,timers,listeners,storage,window,rerun:()=>vm.runInContext(code,context)};
}
assert.equal(run(undefined).calls.length,0);
assert.equal(run({...purchase,value:NaN}).calls.length,0);
assert.equal(run({...purchase,value:-1}).calls.length,0);
const paid=run(purchase);assert.equal(paid.calls.length,1);
assert.equal(paid.calls[0][2].value,1275.50);assert.equal(paid.calls[0][2].currency,'INR');
assert.equal(paid.calls[0][3].eventID,purchase.eventId);
paid.rerun();assert.equal(paid.calls.length,1);
assert.equal(run(purchase,{storage:paid.storage}).calls.length,0);
const delayed=run(purchase,{noPixel:true});assert.equal(delayed.calls.length,0);
delayed.window.fbq=(...args)=>delayed.calls.push(args);delayed.timers.shift()();assert.equal(delayed.calls.length,1);
const unavailable=run(purchase,{noPixel:true});let attempts=0;
while(unavailable.timers.length){unavailable.timers.shift()();assert.ok(++attempts<41);}
assert.equal(unavailable.storage.size,0);
const loading=run(purchase,{loading:true});assert.equal(loading.calls.length,0);loading.listeners[0]();assert.equal(loading.calls.length,1);
const denied=run(purchase,{storageDenied:true});denied.rerun();assert.equal(denied.calls.length,1);
console.log('Purchase JS: ordinary pages, invalid data, actual totals, refresh deduplication, delayed/missing pixel, DOM readiness and denied storage passed.');
