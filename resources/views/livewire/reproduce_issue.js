
// Mock Alpine.js environment
const Alpine = {
    data: (name, callback) => {
        // We will instantiate this manually in tests
        return callback;
    }
};

// Mock MathJax
const MathJax = {
    typesetPromise: () => Promise.resolve()
};

global.window = {
    MathJax: MathJax
};

// Mock $wire
const $wire = {
    updateRanking: () => Promise.resolve(),
    nextStep: () => {},
    submit: () => {}
};
global.$wire = $wire;

// Replicate logic from test2.blade.php
const dragDropLogic = (items, partNum) => ({
    items: [], // Original items from DB
    appItems: [], // Local state
    currentMaxOrder: 0,
    draggedId: null,
    partNumber: partNum,
    justDragged: false, // Flag to prevent click after drag

    // Mock $nextTick for Node environment
    $nextTick(callback) {
        callback();
    },

    init() {
        // Initialize
        this.items = items;
        this.resetOrder();
    },

    resetOrder() {
        this.currentMaxOrder = 0;
        // Provide random index - mocking shuffle for deterministic tests if needed, 
        // but for now keeping logic as is since we test logic not randomness.
        // For testing we might want deterministic shuffle.
        const indices = this.shuffle(Array.from({length: this.items.length}, (_, i) => i));
        
        this.appItems = this.items.map((item, index) => ({
            id: item.id,
            display_content: item.display_content,
            order: null, // User selected order (1-18)
            randomIndex: indices[index] // Initial random shuffle position
        }));
        
        this.refreshMathJax();
    },

    get sortedAppItems() {
        return [...this.appItems].sort((a, b) => {
            // Sorted by Order if present, otherwise by randomIndex
            if (a.order !== null && b.order !== null) return a.order - b.order;
            if (a.order !== null) return -1; // Ordered items first
            if (b.order !== null) return 1;
            return a.randomIndex - b.randomIndex;
        });
    },

    get isComplete() {
        return this.currentMaxOrder === this.items.length && this.appItems.every(i => i.order !== null);
    },

    shuffle(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
        return array;
    },

    handleClick(id) {
        // Prevent click if currently dragging or just finished dragging
        if (this.draggedId || this.justDragged) return;
        
        const target = this.appItems.find(i => i.id === id);
        if (!target) return;

        if (target.order === null) {
            this.currentMaxOrder++;
            target.order = this.currentMaxOrder;
        } else {
            // Deselect and shift others down
            const removedOrder = target.order;
            target.order = null;
            this.appItems.forEach(i => {
                if (i.order !== null && i.order > removedOrder) {
                    i.order--;
                }
            });
            this.currentMaxOrder--;
        }
        this.refreshMathJax();
    },

    handleDragStart(e, id) {
        this.draggedId = id;
        // Mock e.target and dataTransfer if needed, mostly used for visual effects
    },

    handleDragEnd(e) {
        this.draggedId = null;
        this.justDragged = true;
        // removing timeout for sync testing or mocking it if we were testing async
        this.justDragged = false; 
    },
    
    // Simplified drop handler for testing logic
    handleDropLogic(sourceId, targetId) {
        if (!sourceId || sourceId === targetId) return;

        const source = this.appItems.find(i => i.id === sourceId);
        const target = this.appItems.find(i => i.id === targetId);

        if (!source || !target) return;

        const sNum = source.order;
        const tNum = target.order;

        if (sNum !== null && tNum === null) {
            // Case 1: Source (Ordered) dropped on Target (Unordered)
            target.order = sNum;
            source.order = null;
            
            const tempIdx = source.randomIndex;
            source.randomIndex = target.randomIndex;
            target.randomIndex = tempIdx;

        } else if (sNum !== null && tNum !== null) {
            // Case 2: Both Ordered
            source.order = tNum;
            target.order = sNum;

        } else if (sNum === null && tNum === null) {
            // Case 3: Both Unordered
            const tempIdx = source.randomIndex;
            source.randomIndex = target.randomIndex;
            target.randomIndex = tempIdx;

        } else if (sNum === null && tNum !== null) {
            // Case 4: Source (Unordered) dropped on Target (Ordered)
            source.order = tNum;
            target.order = null;
            
            const tempIdx = source.randomIndex;
            source.randomIndex = target.randomIndex;
            target.randomIndex = tempIdx;
        }

        this.refreshMathJax();
    },

    refreshMathJax() {
       // No-op for test
    }
});

// --- TESTS ---

const assert = require('assert');

function runTests() {
    console.log("Running TDD Drag & Drop Tests...");

    // Setup Items
    const items = [
        { id: 1, display_content: 'A' },
        { id: 2, display_content: 'B' },
        { id: 3, display_content: 'C' },
        { id: 4, display_content: 'D' }
    ];

    const logic = dragDropLogic(items, 1);
    logic.init();
    
    // Helper to print state
    const printState = () => {
        console.log(logic.appItems.map(i => `ID:${i.id} Order:${i.order} Rnd:${i.randomIndex}`).join(" | "));
    };

    // Force deterministic state for testing logic
    logic.appItems[0].randomIndex = 0; // ID 1
    logic.appItems[1].randomIndex = 1; // ID 2
    logic.appItems[2].randomIndex = 2; // ID 3
    logic.appItems[3].randomIndex = 3; // ID 4
    logic.appItems.forEach(i => i.order = null); // clear orders
    logic.currentMaxOrder = 0;

    console.log("Initial State:");
    printState();

    // Test Case 1: Unordered <-> Unordered
    console.log("\nTest 1: Swap Unordered (ID 1 -> ID 2)");
    // ID 1 (pos 0) dragged to ID 2 (pos 1)
    logic.handleDropLogic(1, 2);
    
    // Expect: ID 1 has Rnd 1, ID 2 has Rnd 0. Orders null.
    assert.strictEqual(logic.appItems.find(i => i.id === 1).randomIndex, 1, "ID 1 should have randomIndex 1");
    assert.strictEqual(logic.appItems.find(i => i.id === 2).randomIndex, 0, "ID 2 should have randomIndex 0");
    printState();
    console.log("PASS");

    // Reset
    logic.appItems[0].randomIndex = 0; logic.appItems[1].randomIndex = 1;

    // Test Case 2: Ordered <-> Ordered
    console.log("\nTest 2: Swap Ordered (ID 1 [Order 1] -> ID 2 [Order 2])");
    logic.appItems.find(i => i.id === 1).order = 1;
    logic.appItems.find(i => i.id === 2).order = 2;
    logic.currentMaxOrder = 2;

    logic.handleDropLogic(1, 2); // Drag Order 1 to Order 2

    // Expect: ID 1 has Order 2, ID 2 has Order 1
    assert.strictEqual(logic.appItems.find(i => i.id === 1).order, 2, "ID 1 should become Order 2");
    assert.strictEqual(logic.appItems.find(i => i.id === 2).order, 1, "ID 2 should become Order 1");
    printState();
    console.log("PASS");

    // Test Case 3: Ordered -> Unordered
    console.log("\nTest 3: Ordered (ID 1 [Order 2]) -> Unordered (ID 3)");
    // Setup: ID 1 (Order 2), ID 2 (Order 1), ID 3 (Null)
    // Drag ID 1 to ID 3.
    // Expectation (Current Logic): 
    // Target (ID 3) gets Order 2. Source (ID 1) becomes Null.
    // Also Rnd Indices swapped between ID 1 and ID 3.
    
    const initialRnd1 = logic.appItems.find(i => i.id === 1).randomIndex;
    const initialRnd3 = logic.appItems.find(i => i.id === 3).randomIndex;

    logic.handleDropLogic(1, 3);

    const source = logic.appItems.find(i => i.id === 1);
    const target = logic.appItems.find(i => i.id === 3);

    assert.strictEqual(source.order, null, "Source should lose order");
    assert.strictEqual(target.order, 2, "Target should gain order 2");
    assert.strictEqual(source.randomIndex, initialRnd3, "Source should take Target's random position");
    assert.strictEqual(target.randomIndex, initialRnd1, "Target should take Source's random position");
    
    printState();
    console.log("PASS");

    // Test Case 4: Unordered -> Ordered
    console.log("\nTest 4: Unordered (ID 1) -> Ordered (ID 2 [Order 1])");
    // Setup: ID 1 (Null), ID 2 (Order 1).
    // Drag ID 1 to ID 2.
    // Expectation (Current Logic):
    // Source (ID 1) gets Order 1. Target (ID 2) becomes Null.
    // Rnd Indices swapped.

    const id1Rnd = logic.appItems.find(i => i.id === 1).randomIndex;
    const id2Rnd = logic.appItems.find(i => i.id === 2).randomIndex;

    logic.handleDropLogic(1, 2);

    const s = logic.appItems.find(i => i.id === 1);
    const t = logic.appItems.find(i => i.id === 2);

    assert.strictEqual(s.order, 1, "Source should gain Order 1");
    assert.strictEqual(t.order, null, "Target should lose order");
    assert.strictEqual(s.randomIndex, id2Rnd, "Source should take Target's random position");
    assert.strictEqual(t.randomIndex, id1Rnd, "Target should take Source's random position");

    printState();
    console.log("PASS");
    
    console.log("\nALL TESTS PASSED");
}

runTests();
