import React, { Component } from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';

export default class About extends Component {
    constructor(){
        super();
        this.state = {
            categories:[]
        }
    }
    componentDidMount(){
        axios.get('http://127.0.0.1:8000/category')
        .then(response => {
            this.setState({categories:response.data})
        })
    }
    onDelete(category_id){
        axios.delete('http://127.0.0.1:8000/category/delete/'+category_id)
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
        })
    }

    render() {
        return (
            <div>
                <h3>Listing component</h3>
                <table className="table">
                <thead>
                    <tr>
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
                                <tr>
                                    <th scope="row" key={category.id}>{category.id}</th>
                                    <td key={category.id}>{category.name}</td>
                                    <td key={category.id}>{category.active == 1 ?("Active"):("In Active")}</td>
                                    <td key={category.id}>{category.created_at}</td>
                                    <td key={category.id}>{category.updated_at}</td>
                                    <td key={category.id}><Link href="#" onClick={this.onDelete.bind(this,category.id)}>Delete</Link></td>

                                </tr>
                            )
                        })
                    }

                </tbody>
                </table>
            </div>
        );
    }
}

