import React, { Component } from 'react';
import axios from 'axios';
import Pagination from 'react-js-pagination';
import { Link } from 'react-router-dom';
import Success from '../alerts/Success';
import Error from '../alerts/Error';

export default class About extends Component {
    constructor(){
        super();
        this.state = {
            categories:[],
            activePage:1,
            itemsCountPerPage:1,
            totalItemsCount:1,
            pageRangeDisplayed:5,
            alert_message:''
        }
        this.handlePageChange = this.handlePageChange.bind(this)
    }
    componentDidMount(){
        axios.get('http://127.0.0.1:8000/api/category')
        .then(response => {
            this.setState({
                categories:response.data.data,
                activePage:response.data.current_page ,
                itemsCountPerPage:response.data.per_page,
                totalItemsCount:response.data.total,
            })
        })
    }

    handlePageChange(pageNumber) {
        axios.get('http://127.0.0.1:8000/api/category?page='+pageNumber)
        .then(response => {
            this.setState({
                categories:response.data.data,
                activePage:response.data.current_page ,
                itemsCountPerPage:response.data.per_page,
                totalItemsCount:response.data.total,
            })
        })
    }

    onDelete(category_id){
        axios.delete('http://127.0.0.1:8000/api/category/delete/'+category_id)
        .then(response => {
            var categories= this.state.categories;
            for(var i=0; i<categories.length;i++){
                if(categories[i].id == category_id){
                    categories.splice(i,1);
                    this.setState({
                        categories : categories
                    })
                }
            }
            this.setState({
                alert_message: 'success'
            })
        })
        .catch(response => {
            this.setState({
                alert_message: 'error'
            })
        })
    }

    render() {
        return (
            <div>
                <hr/>
                {this.state.alert_message == 'success' ? <Success message={'Category deleting successfully'}/> : null}
                {this.state.alert_message == 'error' ? <Error message={'Error occured while deleting category'}/> : null}
                <h3>Listing component</h3>
                <table className="table">
                    <thead>
                        <tr >
                            <th scope="col">#</th>
                            <th scope="col">Category Name</th>
                            <th scope="col">Status</th>
                            <th scope="col">Created At</th>
                            <th scope="col">Updated At</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {
                            this.state.categories.map(category=>{
                                return(
                                    <tr key={category.id}>
                                        <th scope="row">1</th>
                                        <td>{category.name}</td>
                                        <td>{category.active == 1 ?("Active"):("In Active")}</td>
                                        <td>{category.created_at}</td>
                                        <td>{category.updated_at}</td>
                                        <td>
                                            <Link to={`/category/edit/${category.id}`}>Edit</Link>&nbsp;&nbsp;
                                            <a href="#" onClick={this.onDelete.bind(this,category.id)}>Delete</a>
                                        </td>

                                    </tr>
                                )
                            })
                        }

                    </tbody>
                </table>
                <div className="d-flex justify-content-center">
                    <Pagination
                    activePage={this.state.activePage}
                    itemsCountPerPage={this.state.itemsCountPerPage}
                    totalItemsCount={this.state.totalItemsCount}
                    pageRangeDisplayed={this.state.pageRangeDisplayed}
                    onChange={this.handlePageChange.bind(this)}
                    itemClass='page-item'
                    linkClass='page-link'
                    />
                </div>
            </div>
        );
    }
}

