import React, { Component } from 'react';
import axios from 'axios';
import Success from '../alerts/Success';
import Error from '../alerts/Error';

export default class Edit extends Component {
    constructor(props){
        super(props);
        this.onChangeCategoryName = this.onChangeCategoryName.bind(this);
        this.onSubmit = this.onSubmit.bind(this);
        this.state = {
            category_name:'',
            alert_message:''
        }
    }

    componentDidMount(){
        axios.get('http://127.0.0.1:8000/api/category/edit/'+this.props.match.params.id)
        .then(response => {
            this.setState({category_name:response.data.name})
        })
    }

    onChangeCategoryName(e){
        this.setState({
            category_name:e.target.value
        })
    }

    onSubmit(e){
        e.preventDefault();
        const category = {
            category_name : this.state.category_name
        }
        axios.put('http://127.0.0.1:8000/api/category/update/'+this.props.match.params.id,category)
        .then(response => {
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
                {this.state.alert_message == 'success' ? <Success message={'Category update successfully'}/> : null}
                {this.state.alert_message == 'error' ? <Error message={'Error occured while updating category'}/> : null}
                <h3>Edit Category</h3>
                <form onSubmit={this.onSubmit}>
                    <div className="form-group">
                        <label htmlFor="category_name">Category Name</label>
                        <input type="text"
                        className="form-control"
                        id="category_name"
                        placeholder="Category Name"
                        value={this.state.category_name}
                        onChange={this.onChangeCategoryName}/>
                    </div>

                    <button type="submit" className="btn btn-primary">Submit</button>
                </form>
            </div>
        );
    }
}

