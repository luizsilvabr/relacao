const myFunctionI = () => {
    const columns = [
        { name: 'Nome', index: 0, isFilter: true },
        { name: 'Visualizar', index: 2, isFilter: false }

    ]
    const filterColumns = columns.filter(c => c.isFilter).map(c => c.index)
    const trs = document.querySelectorAll('#myTable tr:not(.headerI)')
    const filter = document.querySelector('#tableSearch').value
    const regex = new RegExp(escape(filter), 'i')
    const isFoundInTds = td => regex.test(td.innerHTML)
    const isFound = childrenArr => childrenArr.some(isFoundInTds)
    const setTrStyleDisplay = ({ style, children }) => {
        style.display = isFound([
            ...filterColumns.map(c => children[c]) // <-- filter Columns
        ]) ? '' : 'none'
    }

    trs.forEach(setTrStyleDisplay)
}

// const myFunction = () => {
//     const columns = [
//         { name: 'Placa', index: 0, isFilter: true },
//         { name: 'Porta', index: 1, isFilter: false },
//         { name: 'FTTH', index: 2, isFilter: false },
//         { name: 'Ações', index: 3, isFilter: false }

//     ]
//     const filterColumns = columns.filter(c => c.isFilter).map(c => c.index)
//     var trs = document.querySelectorAll('#Table tr:not(.header)')
//     var filter = document.querySelector('#searchbar').value
//     regex = new RegExp(`^${filter}$`)

//     const isFoundInTds = td => regex.test(td.innerHTML)

//     const isFound = childrenArr => childrenArr.some(isFoundInTds)

//     const setTrStyleDisplay = ({ style, children }) => {
//         style.display = isFound([
//             ...filterColumns.map(c => children[c]) // <-- filter Columns
//         ]) ? '' : 'none'
//     }
//     trs.forEach(setTrStyleDisplay)

//     if (regex == "/^$/") {
//         const setTrStyleDisplay = ({ style, children }) => {
//             style.display = isFound([
//                 ...filterColumns.map(c => children[c]) // <-- filter Columns
//             ]) ? '' : ''
//         }
//         trs.forEach(setTrStyleDisplay)
//     }
// }